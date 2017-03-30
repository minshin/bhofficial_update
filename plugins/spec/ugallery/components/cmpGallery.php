<?php namespace Spec\uGallery\Components;

use Cms\Classes\ComponentBase;
use UberGallery;

class cmpGallery extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Gallery',
            'description' => 'Spec-Gallery'
        ];
    }

    public function defineProperties()
    {
        return [
            'location' => [
                'description'       => 'Image folder (from root)',
                'title'             => 'Images location',
                'default'           => "storage/app/media",
                'type'              => 'string',
            ]
        ];
    }
	
	function View()
	{
	include_once(plugins_path() . '/spec/ugallery/components/gallerij/resources/UberGallery.php');
	$gallery = UberGallery::init()->createGallery($this->property('location'));
	}

}