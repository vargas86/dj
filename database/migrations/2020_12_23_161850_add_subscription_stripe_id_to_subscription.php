<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionStripeIdToSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('subscription_stripe_id')->nullable(true)->after('pack_id');
            $table->string('price')->nullable(true)->after('subscription_stripe_id');
            $table->string('currency')->nullable(true)->after('subscription_stripe_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('subscription_stripe_id');
            $table->dropColumn('price');
            $table->dropColumn('currency');
        });
    }
}
