<?php namespace Xeor\Comments\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('xeor_comments_votes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('comment_id')->nullable()->index();
            $table->integer('value');
            $table->string('value_type');
            $table->integer('user_id')->nullable()->index();
            $table->string('vote_source');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('xeor_comments_votes');
    }
}
