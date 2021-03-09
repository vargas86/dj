<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchoolLatAndSchoolLngAndTopicToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('school_location');
            $table->unsignedBigInteger('topic_id')->nullable(true)->after('email');
            $table->float('school_lat')->unsigned(false)->nullable(true)->after('school_name');
            $table->float('school_lng')->unsigned(false)->nullable(true)->after('school_lat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('school_location');
            $table->dropColumn('topic_id');
            $table->dropColumn('school_lat');
            $table->dropColumn('school_lng');
        });
    }
}
