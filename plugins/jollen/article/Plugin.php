<?php namespace Jollen\Article;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
	public function registerComponents()
	{
		return [
				'Jollen\Article\Components\Thelist'       => 'articlethelist',
				'Jollen\Article\Components\Content'       => 'articlecontent',
				
		];
	}

	public function registerSettings()
	{
	}
	public function registerFormWidgets()
	{
		return [
				'Jollen\Article\FormWidgets\Preview' => [
						'label' => 'Preview',
						'code'  => 'preview'
				]
		];
	}
}
