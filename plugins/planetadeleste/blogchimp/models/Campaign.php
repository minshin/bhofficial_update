<?php namespace PlanetaDelEste\BlogChimp\Models;

use Backend;
use Carbon\Carbon;
use Cms\Classes\Page;
use Exception;
use Flash;
use Log;
use Model;
use NZTim\Mailchimp\DrewMMailchimp;
use PHPHtmlParser\Dom;
use RainLab\Blog\Models\Post;
use Url;

/**
 * Campaign Model
 * @property integer             id
 * @property \Carbon\Carbon|null sent_at
 * @property integer             post_id
 * @property string              campaign_id
 * @property string              p2i_status
 * @property string              p2i_image_url
 */
class Campaign extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'planetadeleste_blogchimp_campaigns';

    protected $fillable = ['campaign_id', 'sent_at'];

    protected $dates = ['sent_at'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'post' => ['RainLab\Blog\Models\Post']
    ];

    public static function importCampaigns()
    {
        $added = 0;
        $mc_args = ['status' => 'sent'];

        $last_campaign = Campaign::orderBy('sent_at', 'desc')->first();
        if ($last_campaign) {
            $mc_args['since_send_time'] = $last_campaign->sent_at->toIso8601String();
        }

        $mc = new DrewMMailchimp(Setting::get('mc_key'));
        $mc_campaigns = $mc->get('/campaigns', $mc_args);
        $selectors = Setting::get('remove_selectors', []);

        if (is_array($mc_campaigns)) {
            $dom = new Dom;
            foreach ($mc_campaigns['campaigns'] as $mc_campaign) {
                if (!array_key_exists('id', $mc_campaign)) {
                    continue;
                }

                if ($mc_campaign['status'] != 'sent') {
                    continue;
                }

                $campaign = Campaign::where('campaign_id', $mc_campaign['id'])->first();

                if ($campaign) {
                    continue;
                }

                $mc_campaign_content = $mc->get('/campaigns/'.$mc_campaign['id'].'/content');
                $dom->load($mc_campaign_content['html']);
                $html_body = $dom->find('body', 0);

                // Remove elements
                if (count($selectors)) {
                    foreach ($selectors as $selector) {
                        $element = $html_body->find($selector['selector']);
                        if ($element->count()) {
                            $element->delete();
                        }
                    }
                }

                $html = self::removeStyles($html_body->innerHtml);
                //$html = preg_replace('/ style=(["\'])[^\1]*?\1/i', '', $html);

                $blog_post = new Post;
                $blog_post->title = $mc_campaign['settings']['title'];
                $blog_post->slug = str_slug($mc_campaign['settings']['title']);
                $blog_post->published = ($mc_campaign['status'] == 'sent');
                $blog_post->published_at = ($mc_campaign['status'] == 'sent') ? new Carbon(
                    $mc_campaign['send_time']
                ) : null;
                $blog_post->content = $html;
                $blog_post->content_html = $html;
                $blog_post->save();
                $blog_post->campaign()->create(
                    [
                        'campaign_id' => $mc_campaign['id'],
                        'sent_at'     => ($mc_campaign['status'] == 'sent') ? new Carbon(
                            $mc_campaign['send_time']
                        ) : null
                    ]
                );
                self::addP2i($blog_post);
                $added++;
            }
        }

        return $added;
    }

    /**
     * @param Post $post
     */
    public static function addP2i($post)
    {
        // Use page2images service
        $p2i_enabled = Setting::get('use_p2i');
        $p2i_key = Setting::get('p2i_key');
        $p2i_page = Setting::get('p2i_url');
        $p2i_api_url = "http://api.page2images.com/restfullink";

        if (!$p2i_enabled || !$p2i_key || !$p2i_page) {
            return;
        }

        $params = [
            "p2i_url"      => Page::url($p2i_page, ['id' => $post->id, 'slug' => $post->slug]),
            "p2i_key"      => $p2i_key,
            "p2i_device"   => Setting::get('p2i_device', 6),
            "p2i_callback" => Url::to('/p2i_api_callback?post_id='.$post->id),
            "p2i_wait"     => 15,
            "p2i_fullpage" => Setting::get('p2i_fullpage'),
        ];

        if (Setting::get('p2i_screen_width') || Setting::get('p2i_screen_height')) {
            $params['p2i_screen'] = Setting::get('p2i_screen_width', '0').'x'.Setting::get('p2i_screen_height', '0');
        }

        if (Setting::get('p2i_size_width') || Setting::get('p2i_size_height')) {
            $params['p2i_size'] = Setting::get('p2i_size_width', '0').'x'.Setting::get('p2i_size_height', '0');
        }

        try {
            // connect page2images server
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $p2i_api_url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $response = curl_exec($ch);
            curl_close($ch);

            if (empty($response)) {
                // something error
                trace_log("something error");
            } else {
                $json_data = json_decode($response);

                Setting::set('p2i_left_calls', $json_data->left_calls);
                /** @var Campaign $campaign */
                $campaign = $post->campaign;
                $campaign->p2i_status = $json_data->status;

                switch ($json_data->status) {
                    case "error":
                        trace_log($json_data->errno." ".$json_data->msg);
                        break;
                    case "finished":
                        $campaign->p2i_image_url = $json_data->image_url;
                        //echo "<a href='".$json_data->ori_url."'><img src='".$json_data->image_url."'></a>";
                        trace_log(
                            [trans('planetadeleste.blogchimp::lang.import.p2i_status_finished'), $json_data->image_url]
                        );
                        break;
                    case "processing":
                        Log::info(trans('planetadeleste.blogchimp::lang.import.p2i_status_processing'));
                        break;
                }

                $campaign->save();
            }
        } catch (Exception $e) {
            trace_log('Caught exception: '.$e->getMessage());
        }
    }

    public static function removeStyles($tag_source)
    {
        preg_match_all('/style="([^"]*)"/i', $tag_source, $orig_dq_style_vals, PREG_PATTERN_ORDER);
        preg_match_all('/style=\'([^\']*)\'/i', $tag_source, $orig_sq_style_vals, PREG_PATTERN_ORDER);
        $orig_style_vals = array_unique(array_merge($orig_dq_style_vals[1], $orig_sq_style_vals[1]));

        $evil_styles = [];
        $styles = Setting::get('remove_style_attributes', []);
        if (count($styles)) {
            foreach ($styles as $style) {
                $evil_styles[] = $style['css_style'];
            }
        }
        /*$evil_styles = [
            'font',
            'color',
            'font-family',
            'mso-spacerun',
            'font-face',
            'font-size',
            'font-size-adjust',
            'font-stretch',
            'font-variant'
        ];*/
        $evil_style_pttrns = [];
        foreach ($evil_styles as $v) {
            $evil_style_pttrns[] = '/'.$v.'\s*:\s*[^;]*;?/';
        }

        $new_style_vals = [];
        foreach ($orig_style_vals as $style_val) {
            $new_style_vals[] = preg_replace($evil_style_pttrns, '', $style_val);
        }

        return str_replace($orig_style_vals, $new_style_vals, $tag_source);
    }

}