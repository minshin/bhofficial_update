<?php

namespace NamNV609\OCSpotIM\Components;

use Cms\Classes\ComponentBase;

class SpotIM extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Spot.IM',
            'description' => 'Spot.IM plugin - Turn comments into Community',
        ];
    }

    public function defineProperties()
    {
        return [
            'spotId' => [
                'title' => 'ID',
                'description' => 'Spot.IM ID',
                'default' => 'sp_',
                'required' => true,
                'validationPattern' => '^sp_[a-zA-Z0-9]{8,}$',
                'validationMessage' => 'Spot.IM ID is invalid',
                'placeholder' => 'Enter Spot.IM ID',
            ]
        ];
    }

    public function onRender()
    {
        $this->page['spotIM_spotID'] = $this->property('spotId');
    }
}
