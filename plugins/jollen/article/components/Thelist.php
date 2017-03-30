<?php namespace Jollen\Article\Components;

use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Jollen\Article\Models\Post as ArticlePost;
use Rainlab\Blog\Models\Post as BlogPost;
use Log;

class Thelist extends ComponentBase
{
    /**
     * A collection of posts to display
     * @var Collection
     */
    public $posts;
    public $pp;

 

    public function componentDetails()
    {
        return [
            'name'        => 'jollen.article::lang.settings.posts_title',
            'description' => 'jollen.article::lang.settings.posts_description'
        ];
    }

    public function defineProperties()
    {
        return [

            
            'postPage' => [
                'title'       => 'jollen.article::lang.settings.posts_post',
                'description' => 'jollen.article::lang.settings.posts_post_description',
                'type'        => 'dropdown',
                'default'     => 'article/thelist',
                'group'       => 'Links',
            ],
            
        ];
    }



    public function onRun()
    {
        $this->prepareVars();
        $this->posts= $this->page['thelist'] = $this->listPosts();
        $this->pp = $this->page['thelist'] = $this->gettheinfo();

        /*
         * If the page number is not valid, redirect
         */
        if ($pageNumberParam = $this->paramName('pageNumber')) {
            $currentPage = $this->property('pageNumber');

            if ($currentPage > ($lastPage = $this->posts->lastPage()) && $currentPage > 1)
                return Redirect::to($this->currentPageUrl([$pageNumberParam => $lastPage]));
        }
    }

    protected function prepareVars()
    {
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $this->noPostsMessage = $this->page['noPostsMessage'] = $this->property('noPostsMessage');

        /*
         * Page links
         */
        $this->postPage = $this->page['postPage'] = $this->property('postPage');
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
    }

    protected function listPosts()
    {
        $category = $this->category ? $this->category->id : null;

        /*
         * List all the posts, eager load their categories
         */
        $posts = ArticlePost::paginate(1);
        /*
         * Add a "url" helper attribute for linking to each post and category
         */
//         $posts->each(function($post) {
//             Log::info("ooooooooooooooo");
//             $post->setUrl($this->postPage, $this->controller);
//             Log::info($this->postPage);
//             Log::info($post->url);
//             $post->categories->each(function($category) {
//                 $category->setUrl($this->categoryPage, $this->controller);
//             });
//         });

        return $posts;
    }
    protected function gettheinfo()
    {
    	
    
    	$posts = BlogPost::paginate(2);
    	
    
    	return $posts;
    }

   
}
