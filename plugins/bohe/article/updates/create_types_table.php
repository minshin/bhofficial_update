<?php namespace Bohe\Article\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTypesTable extends Migration
{

    public function up()
    {
        Schema::create('bohe_doctor_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->index();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            $table->timestamps();
        });

        Schema::create('bohe_doctor_posts_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('index_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->primary(['index_id', 'type_id']);
        });
    }

    public function down()
    {
        Schema::drop('bohe_doctor_types');
        Schema::drop('bohe_doctor_posts_types');
    }

}
