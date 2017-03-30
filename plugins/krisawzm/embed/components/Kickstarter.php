<?php
namespace Krisawzm\Embed\Components;

use Cms\Classes\ComponentBase;
use Krisawzm\Embed\Models\Settings;
use Lang;

class Kickstarter extends ComponentBase
{
    /**
     * {@inheritdoc}
     */
    public function componentDetails()
    {
        return [
            'name'        => 'krisawzm.embed::kickstarter.details.name',
            'description' => 'krisawzm.embed::kickstarter.details.description',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function defineProperties()
    {
        $css_units = Settings::get('valid_css_units', 'px');
        
        return [
            'url' => [
                'title'             => 'krisawzm.embed::kickstarter.properties.url.title',
                'description'       => 'krisawzm.embed::kickstarter.properties.url.description',
                'default'           => 'https://',
                'type'              => 'string',
                'validationPattern' => '^https?:\/\/(www\.)?kickstarter\.com\/?.+$',
                'validationMessage' => Lang::get('krisawzm.embed::kickstarter.properties.url.validationMessage'),
            ],

            'type' => [
                'title'             => 'krisawzm.embed::kickstarter.properties.type.title',
                'description'       => 'krisawzm.embed::kickstarter.properties.type.description',
                'default'           => 'video',
                'type'              => 'dropdown',
                'options'           => ['video' => 'Video', 'card' => 'Card'],
            ],

            'width' => [
                'title'             => 'krisawzm.embed::common.properties.width.title',
                'description'       => 'krisawzm.embed::kickstarter.properties.width.description',
                'default'           => '360',
                'type'              => 'string',
                'validationPattern' => '^(auto|0)$|^\d+(\.\d+)?(%|'.$css_units.')?$',
                'validationMessage' => Lang::get('krisawzm.embed::common.properties.width.validationMessage'),
            ],

            'height' => [
                'title'             => 'krisawzm.embed::common.properties.height.title',
                'description'       => 'krisawzm.embed::kickstarter.properties.height.description',
                'default'           => '480',
                'type'              => 'string',
                'validationPattern' => '^(auto|0)$|^\d+(\.\d+)?(%|'.$css_units.')?$',
                'validationMessage' => Lang::get('krisawzm.embed::common.properties.height.validationMessage'),
            ],
        ];
    }

    /**
     * Get the iframe src.
     *
     * @return string
     */
    public function src()
    {
        $path = rtrim(parse_url($this->property('url'), PHP_URL_PATH), '/');

        return '//www.kickstarter.com' . $path . '/widget/' .
               $this->property('type') . '.html';
    }
}
