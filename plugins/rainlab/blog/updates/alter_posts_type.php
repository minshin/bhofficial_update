<?php namespace RainLab\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AlterPostsType extends Migration
{

	public function up()
	{
			Schema::table('rainlab_blog_posts',function($table)
		{
			$table->integer('type')->nullable()->after('title');
		});
	}

	public function down()
	{
		$table->dropColumn('type');
	}

}
