<?php namespace PolloZen\MostVisited\Components;

use Cms\Classes\ComponentBase;
use Carbon\Carbon;
use PolloZen\MostVisited\Models\Visits;

class RegisterVisit extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Register Visit',
            'description' => 'Attach this component to your blog post page/partial in order to register the user visit'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function onRun(){
        if($this->page[ 'thepost' ]){
            if($this->page[ 'thepost' ]->id){
                $idPost = $this->page[ 'thepost' ]->id;
                $today = Carbon::today();
                $visit = new Visits;
                $visit = $visit->firstOrCreate(['post_id'=>$idPost, 'date'=>$today]);
                $visit->whereId($visit->id)->increment('visits');
            }
        }
    }
}
