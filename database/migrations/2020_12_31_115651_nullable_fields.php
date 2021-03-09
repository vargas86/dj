<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('free')->nullable(true)->change();
            $table->integer('duration')->nullable(true)->change();
            $table->string('title')->nullable(true)->change();
            $table->string('slug')->nullable(true)->change();
            $table->unsignedBigInteger('topic_id')->nullable(true)->change();
            $table->unsignedBigInteger('channel_id')->nullable(true)->change();
            $table->string('description')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('free')->nullable(false)->change();
            $table->integer('duration')->nullable(false)->change();
            $table->string('title')->nullable(false)->change();
            $table->string('slug')->nullable(false)->change();
            $table->unsignedBigInteger('topic_id')->nullable(false)->change();
            $table->unsignedBigInteger('channel_id')->nullable(false)->change();
            $table->string('description')->nullable(false)->change();
        });
    }
}
