<?php namespace Bohe\Article;

use System\Classes\PluginBase;
use Backend;

class Plugin extends PluginBase
{
	public function pluginDetails()
	{
		return [
				'name'        => 'bohe.article::lang.name',
				'description' => 'bohe.article::lang.description',
				'author'      => 'bohe.article::lang.author',
				'icon'        => 'icon-pencil',
				'homepage'    => 'https://github.com/rainlab/blog-plugin'
		];
	}
	public function registerComponents()
	{
		return [
				'Bohe\Article\Components\Bohelist'       => 'articlebohelist',
	
		];
	}
	/**
	 * Registers any back-end permissions used by this plugin.
	 *
	 * @return array
	 */
	public function registerPermissions()
	{
		return [
				'bohe.article.access_articles' => [
						'tab' => 'bohe.article::lang.tab',
						'label' => 'bohe.article::lang.label',
				],
		];
	}
	
    public function registerSettings()
    {
    }
    public function registerNavigation()
    {
    	return [
    			'article' => [
    					'label'       => 'bohe.article::lang.label',
    					'url'         => Backend::url('bohe/article/index'),
    					'icon'        => 'icon-pencil',
    					'iconSvg'     => 'plugins/bohe/article/assets/images/doctor.svg',
    					'permissions' => ['bohe.article.*'],
    					'order'       => 50,
    			]
    	];
    }
}