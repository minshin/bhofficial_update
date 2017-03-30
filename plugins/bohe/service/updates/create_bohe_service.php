<?php namespace Bohe\Service\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateBoheService extends Migration
{

    public function up()
    {
        Schema::create('bohe_article_service', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->longText('content_html')->nullable();
            $table->boolean('state')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('bohe_article_service');
    }

}
