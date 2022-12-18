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
        Schema::create('moneris_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('data_key', 25)->unique();
            $table->string('cust_id', 50);
            $table->string('email', 30);
            $table->string('phone', 30);
            $table->string('note', 30);
            $table->string('masked_pan', 20);
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moneris_tokens');
    }
};
