<?php namespace Yang\Tester\Components;

use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Yang\Tester\Models\Tester as Tester;
use Log;

class Content extends ComponentBase
{
    /**
     * A collection of posts to display
     * @var Collection
     */
    public $posts;

 

    public function componentDetails()
    {
        return [
            'name'        => 'yang.tester::lang.settings.posts_title',
            'description' => 'yang.tester::lang.settings.posts_description'
        ];
    }

    public function defineProperties()
    {
        return [

            
            'postPage' => [
                'title'       => 'yang.tester::lang.settings.posts_post',
                'description' => 'yang.tester::lang.settings.posts_post_description',
                'type'        => 'dropdown',
                'default'     => 'tester/content',
                'group'       => 'Links',
            ],
            
        ];
    }



    public function onRun()
    {
        //var_dump($this->listPosts());die;
        $this->posts = $this->page['thecontent'] = $this->listPosts();

        /*
         * If the page number is not valid, redirect
         */
        if ($pageNumberParam = $this->paramName('pageNumber')) {
            $currentPage = $this->property('pageNumber');

            if ($currentPage > ($lastPage = $this->posts->lastPage()) && $currentPage > 1)
                return Redirect::to($this->currentPageUrl([$pageNumberParam => $lastPage]));
        }
    }



    protected function listPosts()
    {
        $id = $this->param('id');

        /*
         * List all the posts, eager load their categories
         */
        $posts = Tester::where('id', $id)->first();
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

   
}
