<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('subscription_id')->nullable(true);
            $table->integer('stripe_price_id')->nullable(true);
            $table->string('stripe_payment_id', 100)->nullable(true);
            $table->string('payment_intent', 60)->nullable(true);
            $table->integer('amount_paid')->nullable(true);
            $table->string('currency', 3)->nullable(true);
            $table->string('status', 10)->nullable(true); // CANCELED || REFUNDED || PAID
            $table->timestamp('period_start')->nullable(true);
            $table->timestamp('period_end')->nullable(true);
            $table->integer('insctuctor_amount')->nullable(true);
            $table->timestamp('transferred_at')->nullable(true);
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
        Schema::dropIfExists('payments');
    }
}
