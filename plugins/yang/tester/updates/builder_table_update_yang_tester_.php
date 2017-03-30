<?php namespace Yang\Tester\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateYangTester extends Migration
{
    public function up()
    {
        Schema::table('yang_tester_', function($table)
        {
            $table->boolean('state')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('yang_tester_', function($table)
        {
            $table->dropColumn('state');
        });
    }
}
