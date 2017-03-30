<?php namespace Yang\Tester\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateYangTester2 extends Migration
{
    public function up()
    {
        Schema::table('yang_tester_', function($table)
        {
            $table->integer('state')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('yang_tester_', function($table)
        {
            $table->boolean('state')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
