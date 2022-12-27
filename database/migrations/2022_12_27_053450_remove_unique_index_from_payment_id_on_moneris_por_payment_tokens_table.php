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
        Schema::table('moneris_por_payment_tokens', function (Blueprint $table) {
            $table->dropUnique('moneris_por_payment_tokens_payment_id_unique');
            $table->integer('payment_id')->nullable()->change();
            $table->dateTime('date')->nullable()->change();
            $table->bigInteger('operator_id')->nullable()->change();
            $table->bigInteger('customer_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moneris_por_payment_tokens', function (Blueprint $table) {
            $table->integer('payment_id')->nullable(false)->change();
            $table->unique('payment_id');
            $table->dateTime('date')->nullable(false)->change();
            $table->bigInteger('operator_id')->nullable(false)->change();
            $table->bigInteger('customer_id')->nullable(false)->change();
        });
    }
};
