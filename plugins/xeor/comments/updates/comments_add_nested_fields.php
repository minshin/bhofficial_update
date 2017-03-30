<?php namespace Xeor\Comments\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xeor\Comments\Models\Comment as CommentModel;

class CommentsAddNestedFields extends Migration
{

    public function up()
    {
        if (Schema::hasColumn('xeor_comments_comments', 'parent_id')) {
            return;
        }

        Schema::table('xeor_comments_comments', function($table) {
            $table->renameColumn('pid', 'parent_id');
        });

        Db::statement('ALTER TABLE `xeor_comments_comments` MODIFY `parent_id` INTEGER UNSIGNED NULL;');

        Schema::table('xeor_comments_comments', function($table)
        {
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            $table->string('thread');
        });

        foreach (CommentModel::all() as $comment) {
            $comment->setDefaultLeftAndRight();
            $comment->save();
        }
    }

    public function down()
    {
    }

}