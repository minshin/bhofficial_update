<?php namespace Bohe\Service;

use System\Classes\PluginBase;
use Backend;

class Plugin extends PluginBase
{
	public function registerComponents()
	{
		return [
				'Bohe\Service\Components\Boheservice'       => 'boheservice',
	
		];
	}
	public function registerFormWidgets()
	{
		return [
				'Bohe\Service\FormWidgets\Preview' => [
						'label' => 'Preview',
						'code'  => 'preview'
				]
		];
	}
    public function registerSettings()
    {
    }
    public function registerPermissions()
    {
    	return [
    			'bohe.service.access_service' => [
    					'tab' => 'bohe.service::lang.tab',
    					'label' => 'bohe.service::lang.label',
    			],
    	];
    }
    public function registerNavigation()
    {
    	return [
    			'service' => [
    					'label'       => 'bohe.service::lang.label',
    					'url'         => Backend::url('bohe/service/index'),
    					'icon'        => 'icon-pencil',
    					'iconSvg'     => 'plugins/bohe/service/assets/images/article.svg',
    					'permissions' => ['bohe.service.*'],
    					'order'       => 50,
    			]
    	];
    }
}