<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugtrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugtrack', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('severity')->default('medium'); // Changed to string field
            $table->string('status')->default('open'); // Changed to string field
            $table->string('flow')->nullable();
            $table->text('expected_results')->nullable();
            $table->text('actual_results')->nullable();
            $table->string('attachment')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('reported_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bugtrack');
    }
}
