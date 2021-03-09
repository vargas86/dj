<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('topic_id');
            $table->string('slug', 20)->unique();
            $table->string('title', 100);
            $table->string('description', 2000);
            $table->dateTime('schedule');
            $table->boolean('chat');
            $table->string('thumbnail', 30);
            $table->char('language', 2);
            $table->boolean('disabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('topic_id')->references('id')->on('topics');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lives');
    }
}
