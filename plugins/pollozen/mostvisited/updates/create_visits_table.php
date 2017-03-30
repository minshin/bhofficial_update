<?php namespace PolloZen\MostVisited\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateVisitsTable extends Migration
{
    public function up()
    {
        Schema::create('pollozen_mostvisited_visits', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->date('date');
            $table->smallInteger('visits')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pollozen_mostvisited_visits');
    }

}