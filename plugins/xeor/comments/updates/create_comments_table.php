<?php namespace Xeor\Comments\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCommentsTable extends Migration
{

    public function up()
    {
        Schema::create('xeor_comments_comments', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('cid')->index();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('hostname')->nullable();
            $table->boolean('published')->default(true);
            $table->string('name')->nullable();
            $table->string('mail')->nullable();
            $table->string('homepage')->nullable();
            $table->text('content')->nullable();
            $table->text('content_html')->nullable();
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            $table->string('thread');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('xeor_comments_comments');
    }

}
