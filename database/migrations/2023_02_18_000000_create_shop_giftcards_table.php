<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('shop_giftcard_user');
        Schema::dropIfExists('shop_giftcards');

        Schema::create('shop_giftcards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->unsignedDecimal('original_balance');
            $table->unsignedDecimal('balance');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->timestamps();
        });

        Schema::create('shop_giftcard_payment', function (Blueprint $table) {
            $table->unsignedInteger('payment_id');
            $table->unsignedInteger('giftcard_id');
            $table->unsignedDecimal('amount');

            $table->foreign('payment_id')->references('id')->on('shop_payments')->cascadeOnDelete();
            $table->foreign('giftcard_id')->references('id')->on('shop_giftcards')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_giftcards');
        Schema::dropIfExists('shop_giftcard_payment');
    }
};
