<?php namespace Bohe\Article\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Bohe\Article\Models\Type as Type;
use Flash;

class Types extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ReorderController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';

   // public $requiredPermissions = ['rainlab.blog.access_categories'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Bohe.Article', 'article', 'types');
    }

    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $categoryId) {
                if ((!$category = Type::find($categoryId)))
                    continue;

                $category->delete();
            }

            Flash::success('Successfully deleted those categories.');
        }

        return $this->listRefresh();
    }
}