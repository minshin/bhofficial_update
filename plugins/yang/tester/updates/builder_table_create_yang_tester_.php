<?php namespace Yang\Tester\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateYangTester extends Migration
{
    public function up()
    {
        Schema::create('yang_tester_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('pic', 200)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('yang_tester_');
    }
}
