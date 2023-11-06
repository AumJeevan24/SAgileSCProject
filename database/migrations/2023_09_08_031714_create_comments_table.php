<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('forum_id'); // Foreign key to link to the forum// Foreign key to link to the user who posted the comment
            $table->unsignedBigInteger('user_id'); // Foreign key to link to the user who posted the comment
            $table->text('content');                 // The content of the comment
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
