<?php namespace Bohe\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateBoheDoctor extends Migration
{

    public function up()
    {
        Schema::create('bohe_article_doctor', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('jobtitle')->nullable();
            $table->string('skilledin')->nullable();
            $table->longText('introduce')->nullable();
            $table->integer('level')->nullable();
            $table->boolean('state')->default(true);
            $table->string('url')->nullable();
            $table->string('phone')->nullable();
            $table->string('wechat')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('bohe_article_doctor');
    }

}
