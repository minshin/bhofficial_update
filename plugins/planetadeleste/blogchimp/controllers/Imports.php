<?php namespace PlanetaDelEste\BlogChimp\Controllers;

use Backend;
use Backend\Classes\Controller;
use Flash;
use PlanetaDelEste\BlogChimp\Models\Campaign;
use PHPHtmlParser\Dom;

/**
 * Imports Back-end Controller
 */
class Imports extends Controller
{
    public function index()
    {
        $add_campaigns = Campaign::importCampaigns();
        if($add_campaigns)
            Flash::success(trans('planetadeleste.blogchimp::lang.import.campaign_imported'));
        else
            Flash::info(trans('planetadeleste.blogchimp::lang.import.no_campaigns_to_import'));

        return Backend::redirect('rainlab/blog/posts');

        //return $this->makePartial('index_php');
    }

}
