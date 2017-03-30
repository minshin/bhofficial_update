<?php namespace PlanetaDelEste\BlogChimp;

use App;
use Backend;
use Event;
use Illuminate\Foundation\AliasLoader;
use PlanetaDelEste\BlogChimp\Models\Campaign;
use PlanetaDelEste\BlogChimp\Models\Setting;
use RainLab\Blog\Controllers\Posts;
use RainLab\Blog\Models\Post;
use System\Classes\PluginBase;

/**
 * BlogChimp Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog', 'AnandPatel.WysiwygEditors', 'PlanetaDelEste.Widgets'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'planetadeleste.blogchimp::lang.plugin.name',
            'description' => 'planetadeleste.blogchimp::lang.plugin.description',
            'author'      => 'PlanetaDelEste',
            'icon'        => 'icon-envelope-o'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        App::register(\NZTim\Mailchimp\MailchimpServiceProvider::class);

        $alias = AliasLoader::getInstance();
        $alias->alias('Mailchimp', \NZTim\Mailchimp\MailchimpFacade::class);

        Event::listen(
            'backend.menu.extendItems',
            function ($manager) {
                // override main menu icon
                /** @var \Backend\Classes\NavigationManager $manager */
                $manager->addSideMenuItem(
                    'RainLab.Blog',
                    'blog',
                    'blogchimp',
                    [
                        'label'       => 'planetadeleste.blogchimp::lang.plugin.name',
                        'url'         => Backend::url('planetadeleste/blogchimp/imports'),
                        'icon'        => 'icon-envelope-o',
                        'iconSvg'     => 'plugins/planetadeleste/blogchimp/assets/images/blogchimp-icon.svg',
                        'permissions' => ['planetadeleste.blogchimp.import'],
                        'order'       => 500,
                    ]
                );

            }
        );

        Post::extend(function ($model){
            $model->implement[] = 'PlanetaDelEste.BlogChimp.Behaviors.CampaignModel';
        });

        Posts::extendListColumns(function($list, $model) {

            if (!$model instanceof Post)
                return;

            $list->addColumns([
                'blogchimp' => [
                    'label' => 'planetadeleste.blogchimp::lang.posts.mailchimp_column',
                    'type' => 'partial',
                    'sortable' => false,
                    'path' => '$/planetadeleste/blogchimp/partials/_mailchimp_column_php.htm'
                ]
            ]);

            if(Setting::get('use_p2i')) {
                $list->addColumns([
                    'p2i' => [
                        'label' => 'planetadeleste.blogchimp::lang.posts.p2i_column',
                        'type' => 'partial',
                        'sortable' => false,
                        'path' => '$/planetadeleste/blogchimp/partials/_p2i_column_php.htm'
                    ]
                ]);
            }

        });
    }


    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'planetadeleste.blogchimp.setting' => [
                'tab'   => 'planetadeleste.blogchimp::lang.plugin.name',
                'label' => 'planetadeleste.blogchimp::lang.permissions.setting'
            ],
            'planetadeleste.blogchimp.import'  => [
                'tab'   => 'planetadeleste.blogchimp::lang.plugin.name',
                'label' => 'planetadeleste.blogchimp::lang.permissions.import'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [];

        /*return [
            'blogchimp' => [
                'label'       => 'planetadeleste.blogchimp::lang.plugin.name',
                'url'         => Backend::url('planetadeleste/blogchimp/mycontroller'),
                'icon'        => 'icon-leaf',
                'iconSvg'     => 'plugins/planetadeleste/blogchimp/assets/images/blogchimp-icon.svg',
                'permissions' => ['planetadeleste.blogchimp.*'],
                'order'       => 500,
            ],
        ];*/
    }

    public function registerSettings()
    {
        return [
            'setting' => [
                'label'       => 'planetadeleste.blogchimp::lang.plugin.name',
                'description' => 'planetadeleste.blogchimp::lang.plugin.description',
                'permissions' => ['planetadeleste.blogchimp.setting'],
                'category'    => 'planetadeleste.blogchimp::lang.plugin.name',
                'icon'        => 'icon-envelope-o',
                'class'       => 'PlanetaDelEste\BlogChimp\Models\Setting',
                'order'       => 100,
            ],
        ];
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(
            function () {
                Campaign::importCampaigns();
            }
        )->daily();
    }

}
