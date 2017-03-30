<?php namespace Tang\Product\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTangProductTable extends Migration
{
    public function up()
    {
        Schema::create('tang_product_table', function($table)
        {
            $table->engine = 'InnoDB';
            $table->text('title');
            $table->text('abstract');
            $table->string('logo', 200);
            $table->integer('country')->unsigned();
            $table->text('label')->nullable();
            $table->string('website', 200)->nullable();
            $table->integer('category')->unsigned();
            $table->integer('price')->unsigned();
            $table->date('dday');
            $table->integer('founderid')->unsigned();
            $table->text('financeevent');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tang_product_table');
    }
}
