<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCommentsForeignKey extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            // Drop existing foreign key constraint if it exists
            $table->dropForeign(['forum_id']);

            // Add new foreign key constraint with onDelete('cascade')
            $table->foreign('forum_id')
                  ->references('id')
                  ->on('forums')
                  ->onDelete('cascade'); // Enable cascading deletion
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['forum_id']);

            // Re-add the foreign key without onDelete('cascade') if needed
            $table->foreign('forum_id')
                  ->references('id')
                  ->on('forums');
        });
    }
}
