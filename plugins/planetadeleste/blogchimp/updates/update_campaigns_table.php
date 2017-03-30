<?php namespace PlanetaDelEste\BlogChimp\Updates;


use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class update_campaigns_table
 * @package PlanetaDelEste\BlogChimp\Updates
 */
class UpdateCampaignsTable extends Migration
{

    public function up()
    {
        Schema::table('planetadeleste_blogchimp_campaigns', function ($table) {
        	/**
             * @var $table \Illuminate\Database\Schema\Blueprint
             */
        	$table->string('p2i_status', 50)->nullable();
        	$table->string('p2i_image_url', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::table('planetadeleste_blogchimp_campaigns', function ($table) {
        	/**
             * @var $table \Illuminate\Database\Schema\Blueprint
             */
        	$table->dropColumn('p2i_status', 'p2i_image_url');
        });
    }

}