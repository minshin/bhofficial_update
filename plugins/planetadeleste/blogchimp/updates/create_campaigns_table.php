<?php namespace PlanetaDelEste\BlogChimp\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCampaignsTable extends Migration
{
    public function up()
    {
        Schema::create('planetadeleste_blogchimp_campaigns', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('sent_at')->nullable();
            $table->integer('post_id')->unsigned()->nullable();
            $table->string('campaign_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('planetadeleste_blogchimp_campaigns');
    }
}
