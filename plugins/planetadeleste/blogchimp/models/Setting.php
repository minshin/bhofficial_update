<?php namespace PlanetaDelEste\BlogChimp\Models;

use Cms\Classes\Page;
use Flash;
use Model;
use RainLab\Blog\Models\Post;

/**
 * Setting Model
 * @property mixed|string mc_key
 * @method static get($key, $default = NULL)
 * @method static set($key, $value)
 */
class Setting extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'planetadeleste_blogchimp_setting';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'p2i_screen_width'  => 'integer',
        'p2i_screen_height' => 'integer',
        'p2i_size_width'    => 'integer',
        'p2i_size_height'   => 'integer',
    ];

    public function afterSave()
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, 'MC_KEY='.self::get('mc_key'));
        }
    }

    public function getP2iDeviceOptions()
    {
        return [
            0 => 'iPhone4',
            1 => 'iPhone5',
            2 => 'Android',
            3 => 'WinPhone',
            4 => 'iPad',
            5 => 'Android Pad',
            6 => 'Desktop',
            7 => 'iPhone6',
            8 => 'iPhone6+'
        ];
    }

    public function getP2iUrlOptions()
    {
        return Page::getNameList();
    }

    public function onRegenerateP2i()
    {
        $campaigns = Campaign::all();
        $campaigns->each(function ($campaign){
            /** @var Post $blog_post */
            $blog_post = $campaign->post;
            if($blog_post->featured_images->count()) {
                foreach ($blog_post->featured_images as $image) {
                    $image->delete();
                }
            }
            Campaign::addP2i($blog_post);
        });
        return Flash::info(trans('planetadeleste.blogchimp::lang.setting.regenerate_images_processing'));
    }

}