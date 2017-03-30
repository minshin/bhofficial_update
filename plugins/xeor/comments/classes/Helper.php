<?php namespace Xeor\Comments\Classes;

use DB;
use Log;
use Event;

class Helper {

    public static function getPlugins() {

        $options = [
            'blog' => e(trans('xeor.comments::lang.settings.comments_plugin_rainlab_blog')),
            'cms' => e(trans('xeor.comments::lang.settings.comments_plugin_cms')),
            'pages' => e(trans('xeor.comments::lang.settings.comments_plugin_rainlab_pages')),
        ];

        Event::fire('xeor.comments.extendPluginOptions', [&$options]);

        return $options;
    }

}