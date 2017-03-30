<?php namespace Xeor\Comments;

use Db;
use Mail;
use Event;
use Input;
use Backend;
use Request;
use Controller;
use System\Classes\PluginBase;
use Xeor\Comments\Classes\Helper;
use Xeor\Comments\Models\Settings;

class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'xeor.comments::lang.plugin.name',
            'description' => 'xeor.comments::lang.plugin.description',
            'author' => 'Sozonov Alexey',
            'icon' => 'icon-comments'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Xeor\Comments\Components\Comments' => 'comments',
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
            'xeor.comments.access_other_comments' => [
                'tab' => 'xeor.comments::lang.comments.comments',
                'label' => 'xeor.comments::lang.comments.access_other_comments'
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
        return [
            'comments' => [
                'label' => 'xeor.comments::lang.comments.comments',
                'url' => Backend::url('xeor/comments/comments'),
                'icon' => 'icon-comments',
                'iconSvg' => 'plugins/xeor/comments/assets/images/comments-icon.svg',
                'permissions' => ['xeor.comments.*'],
                'order' => 500,
            ]
        ];
    }

    /**
     * Registers back-end settings for this plugin.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'xeor.comments::lang.settings.menu_label',
                'description' => 'xeor.comments::lang.settings.menu_description',
                'category' => 'xeor.comments::lang.settings.comments',
                'icon' => 'icon-comments',
                'class' => 'Xeor\Comments\Models\Settings',
                'order' => 500,
                'permissions' => ['xeor.comments.*']
            ]
        ];
    }

    /**
     * Registers mail templates for this plugin.
     *
     * @return array
     */
    public function registerMailTemplates()
    {
        return [
            'xeor.comments::mail.new_comment_notify_author' => 'Send a notification of a new comment to the page author.',
            'xeor.comments::mail.new_comment_notify_moderator' => 'Send a comment moderation notification to the comment moderator.'
        ];
    }

    public function boot()
    {

        Event::listen('backend.page.beforeDisplay', function ($controller, $action, $params) {
            $controller->addJs('/plugins/xeor/comments/assets/js/xeor.comments.admin.js');
            $controller->addCss('/plugins/xeor/comments/assets/css/xeor.comments.admin.css');
        });

        Event::listen('backend.menu.extendItems', function ($controller) {
            $items = Helper::getPlugins();
            foreach ($items as $key => $value) {
                $item = [
                    'comments' => [
                        'label' => 'xeor.comments::lang.comments.comments',
                        'icon' => 'icon-comments',
                        'attributes' => ['data-menu-item' => 'comments', 'id' => 'js-comments'],
                        'url' => '/backend/xeor/comments/comments?action=filter&type=' . $key
                    ]
                ];
                $controller->addSideMenuItems($value, $key, $item);
            }
        });

        Event::listen('backend.filter.extendScopesBefore', function ($filter) {

            $uri = Request::path();

            if (strpos($uri, 'xeor/comments/comments') !== false) {

                $options = Helper::getPlugins();

                $scope = [
                    'type' => [
                        'label' => 'xeor.comments::lang.comments.filter_type',
                        'scope' => 'FilterTypes',
                        'modelClass' => 'Xeor\Comments\Models\Comment',
                        'options' => $options
                    ]
                ];
                $filter->addScopes($scope);

                $action = Input::get('action');
                switch ($action) {
                    case 'filter':
                        $type = Input::get('type');
                        if (isset($options[$type]))
                            $filter->setScopeValue('type', [$type => $options[$type]]);
                        break;
                }


            }

        });

        Event::listen('xeor.comments.afterSaveComment', function ($comment) {
            $email = Db::table('backend_users')->where('id', 1)->pluck('email');

            $settings = Settings::instance();
            $commentsNotify = $settings->comments_notify;
            $moderationNotify = $settings->moderation_notify;
            $commentModeration = $settings->comment_moderation;

            /**
             * Send a notification of a new comment to the admin.
             */
            if ($commentsNotify && $comment->published) {
                Mail::sendTo($email, 'xeor.comments::mail.new_comment_notify_author', [
                    'comment'  => $comment,
                ]);
            }

            /**
             * Send a comment moderation notification to the admin.
             */
            if ($moderationNotify && $commentModeration && !$comment->published) {
                Mail::sendTo($email, 'xeor.comments::mail.new_comment_notify_moderator', [
                    'comment'  => $comment,
                ]);
            }

        });

//        Example
//        Event::listen('xeor.comments.extendPluginOptions', function (&$options) {
//            $options['custom'] = 'Xeor.Custom';
//        });
    }
}
