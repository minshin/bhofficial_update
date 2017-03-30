<?php namespace Xeor\Comments\Controllers;

use DB;
use Debugbar;
use Log;
use Flash;
use Backend;
use Session;
use Redirect;
use BackendMenu;
use Backend\Classes\Controller;
use Xeor\Comments\Models\Comment;
use Xeor\Comments\Models\Vote;
use Xeor\Comments\Classes\Helper;

class Comments extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController'
    ];

    public $listConfig = 'config_list.yaml';

    public $bodyClass = 'compact-container';

    public $requiredPermissions = ['xeor.comments.access_other_comments'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Xeor.Comments', 'comments', 'comments');
    }

    public function index()
    {
        $this->vars['total'] = Comment::count();
        $this->vars['published'] = Comment::isPublished()->count();
        $this->vars['hidden'] = $this->vars['total'] - $this->vars['published'];
        $this->asExtension('ListController')->index();
    }

    public function delete($recordId = null)
    {
        if (($comment = Comment::find($recordId)) && ($comments = $comment->getAllChildrenAndSelf())) {
            foreach ($comments as $comment) {
                $comment->delete();
            }
        }
        Flash::success('Successfully deleted.');
        return Redirect::to('backend/xeor/comments/comments');
    }

    public function approve($recordId = null)
    {
        if (($comment = Comment::find($recordId)) && ($comments = $comment->getAllChildrenAndSelf())) {
            foreach ($comments as $comment) {
                $comment->published = 1;
                $comment->save();
            }
        }
        Flash::success('Successfully show.');
        return Redirect::to('backend/xeor/comments/comments');
    }

    //
    // Toolbar actions
    //

    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
            foreach ($checkedIds as $id) {
                if (($comment = Comment::find($id)) && ($comments = $comment->getAllChildrenAndSelf())) {
                    foreach ($comments as $comment) {
                        $comment->delete();
                    }
                }
            }
            Flash::success('Successfully deleted those comments.');
        }
        return $this->listRefresh();
    }

    public function index_onHide()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
            foreach ($checkedIds as $id) {
                if (($comment = Comment::find($id)) && ($comments = $comment->getAllChildrenAndSelf())) {
                    foreach ($comments as $comment) {
                        $comment->published = 0;
                        $comment->save();
                    }
                }
            }
            Flash::success('Successfully hide those comments.');
        }
        return $this->listRefresh();
    }

    public function index_onShow()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
            foreach ($checkedIds as $id) {
                if (($comment = Comment::find($id)) && ($comments = $comment->getAllChildrenAndSelf())) {
                    foreach ($comments as $comment) {
                        $comment->published = 1;
                        $comment->save();
                    }
                }
            }
            Flash::success('Successfully show those comments.');
        }
        return $this->listRefresh();
    }

    //
    // Update
    //

    protected function makeEditFormWidget($comment)
    {
        $widgetConfig = $this->makeConfig('~/plugins/xeor/comments/classes/comment/fields.yaml');
        $widgetConfig->alias = 'comment' . $comment->id;
        $widgetConfig->model = $comment;
        $widgetConfig->arrayName = 'Comment';
        $widgetConfig->context = 'update';

        $this->vars['commentId'] = $comment->id;
        $widget = $this->makeWidget('Backend\Widgets\Form', $widgetConfig);
        return $widget;
    }

    public function index_onLoadEditForm()
    {
        $commentId = post('id');
        $comment = Comment::find($commentId);

        if (!$comment)
            return;

        $this->vars['widget'] = $this->makeEditFormWidget($comment);
        return $this->makePartial('comment_edit_form');
    }

    public function index_onEdit()
    {
        $commentId = post('id');
        $comment = Comment::find($commentId);
        $widget = $this->makeEditFormWidget($comment);
        $data = $widget->getSaveData();
        foreach ($data as $key => $value) {
            $comment->{$key} = $value;
        }
        $comment->save();
        return Redirect::to('backend/xeor/comments/comments');
    }

    //
    // Delete
    //

    public function index_onDeleteComment()
    {
        $commentId = post('id');
        $comment = Comment::find($commentId);

        if (!$comment)
            return;

        $comment->delete();
    }

    //
    // Statistics
    //

    protected function makeStatisticsFormWidget($comment)
    {
        $widgetConfig = $this->makeConfig('~/plugins/xeor/comments/classes/vote/fields.yaml');
        $widgetConfig->alias = 'comment' . $comment->id;
        $widgetConfig->model = $comment;
        $widgetConfig->arrayName = 'Vote';
        $widgetConfig->context = 'preview';

        $this->vars['commentId'] = $comment->id;
        $this->vars['sizes'] = $comment->getStatistics();
        $widget = $this->makeWidget('Backend\Widgets\Form', $widgetConfig);
        return $widget;
    }

    public function index_onLoadStatisticsForm()
    {
        $commentId = post('id');
        $comment = Comment::find($commentId);

        if (!$comment)
            return;

        $this->vars['widget'] = $this->makeStatisticsFormWidget($comment);

        return $this->makePartial('comment_statistics_form');
    }

    public function index_onUpdateRateType()
    {
        $commentId = post('id');
        $comment = Comment::find($commentId);
        $type = post('type');
        return [
            'partial' => $this->makePartial(
                '~/plugins/xeor/comments/models/vote/_chart.htm',
                [
                    'commentId' => $commentId,
                    'sizes' => $comment->getStatistics($type)
                ]
            )
        ];
    }

}