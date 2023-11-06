<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->longText('content'); // You can use 'text' if you don't need formatting.
            $table->text('image_urls')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('project_id'); // Add project_id column
            $table->timestamps();

            // Define foreign key constraints.
            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('project_id')->references('id')->on('projects'); // Reference the 'projects' table
        });
    }

    public function down()
    {
        Schema::dropIfExists('forums');
    }
}
