<?php namespace Yang\Test\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateYangTest extends Migration
{
    public function up()
    {
        Schema::create('yang_test_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->string('name', 100);
            $table->integer('state');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('yang_test_');
    }
}
