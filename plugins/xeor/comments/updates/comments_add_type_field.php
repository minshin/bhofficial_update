<?php namespace Xeor\Comments\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xeor\Comments\Models\Comment as CommentModel;

class CommentsAddTypeField extends Migration
{

    public function up()
    {
        if (Schema::hasColumn('xeor_comments_comments', 'uri')) {
            return;
        }

        Schema::table('xeor_comments_comments', function($table) {
            $table->renameColumn('cid', 'uri');
        });

        Schema::table('xeor_comments_comments', function($table)
        {
            $table->string('type')->nullable()->after('uri');
        });
    }

    public function down()
    {
    }

}