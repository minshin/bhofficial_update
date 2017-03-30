<?php namespace Bohe\Service\Components;

use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Bohe\Service\Models\Index as ServiceIndex;
use Log;

class Boheservice extends ComponentBase
{
    /**
     * A collection of posts to display
     * @var Collection
     */
    public $posts;
    public $post;

 

    public function componentDetails()
    {
        return [
            'name'        => 'bohe.service::lang.settings.posts_title',
            'description' => 'bohe.service::lang.settings.posts_description'
        ];
    }

    public function defineProperties()
    {
        return [

            
            'postPage' => [
                'title'       => 'bohe.service::lang.settings.posts_post',
                'description' => 'bohe.service::lang.settings.posts_post_description',
                'type'        => 'dropdown',
                'default'     => 'article/service',
                'group'       => 'Links',
            ],
            
        ];
    }



    public function onRun()
    {
        //$this->posts= $this->page['thelist'] = $this->listPosts();
        $this->post= $this->page['service'] = $this->getpost();
        


    }



    protected function listPosts()
    {

        /*
         * List all the posts, eager load their categories
         */
        //$posts = ServiceIndex::paginate(1);
    	$id = $this->param('id');
    	
    	/*
    	 * List all the posts, eager load their categories
    	 */
    	$posts = ServiceIndex::where('id', $id)->first();

        return $posts;
    }
    /**
     * 取出单条数据
     * @return unknown
     */
    protected function getpost()
    {

    	$id = $this->param('id');

    	$post = ServiceIndex::where('id', $id)->first();
    
    	return $post;
    }


   
}
