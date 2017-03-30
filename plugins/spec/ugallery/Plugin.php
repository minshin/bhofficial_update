<?php namespace Spec\uGallery;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'Gallery',
            'description' => 'Makes a gallery from a folder',
            'author'      => 'Spec',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            '\Spec\uGallery\Components\cmpGallery' => 'Gallery'
        ];
    }
}
