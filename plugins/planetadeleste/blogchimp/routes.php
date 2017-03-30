<?php

use RainLab\Blog\Models\Post;

set_time_limit(0);
ini_set('display_errors', true);

function downloadFromUrl($url, $outFileName)
{
    $options = [
        CURLOPT_FILE           => fopen($outFileName, 'w+'),
        //CURLOPT_TIMEOUT        => 50, // set this to 8 hours so we dont timeout on big files
        //CURLOPT_URL            => $url,
        //CURLOPT_BINARYTRANSFER => 1,
        //CURLOPT_RETURNTRANSFER => 1,
        //CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER         => 0
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    curl_exec($ch);
    curl_close($ch);
}

Route::any(
    '/p2i_api_callback',
    function () {
        if (Request::query('post_id') && post('result')) {
            $data = json_decode(post('result'));
            $post_id = Request::query('post_id');
            $post = Post::find($post_id);

            if($post) {
                /** @var \PlanetaDelEste\BlogChimp\Models\Campaign $campaign */
                $campaign = $post->campaign;
                $campaign->p2i_status = $data->status;
                if ($data->status == 'finished') {
                    \PlanetaDelEste\BlogChimp\Models\Setting::set('p2i_left_calls', $data->left_calls);
                    $campaign->p2i_image_url = $data->image_url;

                    $post_file = storage_path('temp').'/'.$post->slug.'.'.File::extension($data->image_url);
                    downloadFromUrl(urldecode($data->image_url), $post_file);
                    if (File::exists($post_file)) {
                        $file = new \System\Models\File;
                        $file->fromFile($post_file);
                        $file->save();
                        $post->featured_images()->add($file);
                        if($post->save()) {
                            File::delete($post_file);
                        }
                    } else {
                        trace_log("No se encontro el archivo $post_file");
                        trace_log($data);
                    }
                }
                $campaign->save();
            }
        }
    }
);