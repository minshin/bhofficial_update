<?php
namespace Krisawzm\Embed\Components;

use Cms\Classes\ComponentBase;
use Lang;

class GooglePlus extends ComponentBase
{
    /**
     * {@inheritdoc}
     */
    public function componentDetails()
    {
        return [
            'name'        => 'krisawzm.embed::googleplus.details.name',
            'description' => 'krisawzm.embed::googleplus.details.description',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function defineProperties()
    {
        return [
            'link' => [
                'title'             => 'krisawzm.embed::googleplus.properties.link.title',
                'description'       => 'krisawzm.embed::googleplus.properties.link.description',
                'default'           => 'https://',
                'type'              => 'string',
                'validationPattern' => '^.*$',
                'validationMessage' => Lang::get('krisawzm.embed::googleplus.properties.link.validationMessage'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function onRender()
    {
        $this->addJs('//apis.google.com/js/plusone.js');
    }

    /**
     * Get link to post.
     *
     * @return string
     */
    public function link()
    {
        $link = ltrim($this->property('link'), 'https:');

        if (strpos($link, '//') !== 0) {
            return '//' . $link;
        }

        return $link;
    }
}
