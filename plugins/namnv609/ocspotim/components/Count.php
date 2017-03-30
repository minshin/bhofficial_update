<?php

namespace Namnv609\OCSpotim\Components;

use Cms\Classes\ComponentBase;

class Count extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Replies count',
            'description' => 'Display Replies Count'
        ];
    }

    public function defineProperties()
    {
        return [
            'countingText' => [
                'title' => 'Counting text',
                'description' => 'Display text for counting replies',
                'default' => 'Counting...',
            ]
        ];
    }

    public function onRender()
    {
        $this->page['spotIM_uniquePostId'] = $this->property('postId');
        $this->page['spotIM_countingText'] = $this->property('countingText');
    }
}
