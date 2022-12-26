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
        Schema::create('moneris_por_payment_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('por_token')->nullable();
            $table->string('order_id')->nullable();
            $table->integer('payment_id')->unique();
            $table->integer('batch')->nullable()->index();
            $table->string('store', 3)->nullable();
            $table->dateTime('date');
            $table->foreignId('operator_id')->index();
            $table->boolean('drawer')->nullable();
            $table->string('payment_type', 1)->nullable()->index();
            $table->foreignId('customer_id')->index();
            $table->decimal('payment_amount', $precision = 16, $scale = 2)->nullable();
            $table->string('payment_method', 1)->nullable()->index();
            $table->string('card_reference', 30)->nullable();
            $table->string('notes', 100)->nullable();
            $table->smallInteger('encrypted')->nullable();
            $table->decimal('amount_tendered', $precision = 16, $scale = 2)->nullable();
            $table->string('terminal', 255)->nullable();
            $table->string('accounting_link', 255)->nullable();
            $table->bigInteger('gl_transaction_group_id')->nullable();
            $table->string('transaction_id', 255)->nullable();
            $table->bigInteger('parent_payment_id')->nullable();
            $table->integer('transaction_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moneris_por_payment_tokens');
    }
};
