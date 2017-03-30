<?php

namespace Namnv609\OCSpotim\Components;

use Cms\Classes\ComponentBase;

class Comment extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Comments',
            'description' => 'Display Spot.IM Replies Area'
        ];
    }

    public function defineProperties()
    {
        return [
            'isUnique' => [
                'title' => 'Show unique',
                'description' => 'Show unique comments for each post',
                'default' => '1',
                'type' => 'dropdown',
                'options' => [0 => 'No', 1 => 'Yes'],
            ]
        ];
    }

    public function onRender()
    {
        $this->page['spotIM_isUnique'] = $this->property('isUnique');
    }
}
