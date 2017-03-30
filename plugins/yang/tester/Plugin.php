<?php namespace Yang\Tester;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
	public function registerComponents()
	{
		return [
				'Yang\Tester\Components\Content'       => 'testercontent',
	
		];
	}

    public function registerSettings()
    {
    }
    public function registerFormWidgets()
    {
    	return [
    			'Yang\Tester\FormWidgets\Preview' => [
    					'label' => 'Preview',
    					'code'  => 'preview'
    			]
    	];
    }
}
