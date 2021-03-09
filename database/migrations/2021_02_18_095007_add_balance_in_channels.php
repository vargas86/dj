<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceInChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channels', function (Blueprint $table) {
            //
            $table->integer('balance_total')->nullable(true)->after('pack_id');
            $table->integer('balance_withdrawn')->nullable(true)->after('pack_id');
            $table->integer('balance_current')->nullable(true)->after('pack_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channels', function (Blueprint $table) {
            //
            $table->dropColumn(['balance_total', 'balance_withdrawn', 'balance_current']);
        });
    }
}
