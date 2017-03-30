<?php namespace Clake\UserExtended;

use Backend\Classes\Controller;
use Clake\UserExtended\Classes\UserExtended;
use System\Classes\PluginBase;
use Event;
use Backend;
use System\Classes\SettingsManager;

/**
 * User Extended by Shawn Clake
 * Major Contributors: Quinn Bast
 *
 * User Extended is licensed under the MIT license.
 * @link https://github.com/ShawnClake/UserExtended
 *
 * @version 2.0.00 User Extended Core
 *
 * @author Shawn Clake <shawn.clake@gmail.com>
 * @link https://github.com/ShawnClake
 * @link http://shawnclake.com
 *
 *  Major Contributors:
 * @link https://github.com/QuinnBast
 *
 * @license https://github.com/ShawnClake/UserExtended/blob/master/LICENSE MIT
 *
 * Class Plugin
 * @package Clake\UserExtended
 */
class Plugin extends PluginBase
{

    /**
     * @var array
     */
    public $require = [
        'RainLab.User',
    ];

    /**
     * Returns information about this plugin.
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'UserExtended',
            'description' => 'Adds roles, friends, profiles, and utility functions to the Rainlab User plugin',
            'author' => 'clake',
            'icon' => 'icon-user-plus'
        ];
    }

    /**
     * Adds twig filters and functions
     * @return array
     */
    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'timezonify' => ['Clake\Userextended\Classes\TimezoneHandler', 'twigTimezoneAdjustment'],
                'relative' => ['Clake\Userextended\Classes\TimezoneHandler', 'twigRelativeTimeString'],
            ],
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     * @return void
     */
    public function register()
    {
        /*
         * Registers the UE scaffolding command for creating modules
         */
        $this->registerConsoleCommand('create:uemodule', 'Clake\UserExtended\Console\CreateUEModule');

        /*
         * Registers the UserExtended core module
         */
        Module::register();
    }

    /**
     * Boot method, called right before the request route.
     * @return array
     */
    public function boot()
    {
        /*
         * Boots the modules which were registered with UserExtended
         */
        UserExtended::boot();

        /*
         * Event listener adds the Group Manager button to the side bar of the User backend UI.
         */
        Event::listen('backend.menu.extendItems', function ($manager) {

            $manager->addSideMenuItems('RainLab.User', 'user', [
                /*'groups' => [
                    'label' => 'Group Manager',
                    'url' => Backend::url('clake/userextended/groupsextended'),
                    'icon' => 'icon-users',
                    'order' => 500,
                ],*/
                'roles' => [
                    'label' => 'Role Manager',
                    'url' => Backend::url('clake/userextended/roles/manage'),
                    'icon' => 'icon-pencil',
                    'order' => 600,
                ],
                'users-side' => [
                    'label' => 'Users',
                    'url' => Backend::url('rainlab/user/users'),
                    'icon' => 'icon-user',
                    'order' => 100,
                ],
            ]);

        });

        return [];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     * @return array
     */
    public function registerComponents()
    {
        return array_merge(
            UserExtended::getComponents(),
            []
        );
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'UserExtended Settings',
                'description' => 'Manage user extended settings.',
                'category' => SettingsManager::CATEGORY_USERS,
                'icon' => 'icon-cog',
                'class' => 'Clake\Userextended\Models\Settings',
                'order' => 100,
                'keywords' => 'security user extended',
                'permissions' => ['']
            ]
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     * @return array
     */
    public function registerPermissions()
    {
        return [];
    }

    /**
     * Registers back-end navigation items for this plugin.
     * @return array
     */
    public function registerNavigation()
    {
        return array_merge(
            UserExtended::getNavigation(),
            []
        );
    }

    /**
     * Injects assets from modules. Also overrides the defaults presented in general.js and general.css
     * @param $component
     */
    public static function injectAssets($component)
    {
        //Cant move these out because then the defaults wouldn't have top priority
        $component->addJs('/plugins/clake/userextended/assets/js/general.js');
        $component->addCss('/plugins/clake/userextended/assets/css/general.css');

        /*
         * Handles injecting JS and CSS assets
         */
        $assets = UserExtended::getAssets();

        foreach($assets as $asset)
        {
            $type = trim(substr($asset, strrpos($asset, '.') + 1));
            if($type == 'js')
                $component->addJs($asset);

            if($type == 'css')
                $component->addCss($asset);
        }
    }

    /**
     * Registers mail templates
     * @return array
     */
	public function registerMailTemplates()
    {
        return [
            'clake.userextended::mail.on_group_role_changed' => 'Notify that the users group was changed',
            'clake.userextended::mail.received_friend_request'  => 'Friend request',
            'clake.userextended::mail.received_profile_comment'  => 'New comment on user profile',
            'clake.userextended::mail.register'  => 'Registration confirmation email',
        ];
    }

}
