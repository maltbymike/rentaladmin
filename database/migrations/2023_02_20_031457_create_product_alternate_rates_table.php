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
        Schema::create('product_alternate_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('product_alternate_rate_type_id')->constrained();
            $table->decimal('two_hour_rate', 11, 2)->nullable();
            $table->decimal('four_hour_rate', 11, 2)->nullable();
            $table->decimal('daily_rate', 11, 2)->nullable();
            $table->decimal('weekly_rate', 11, 2)->nullable();
            $table->decimal('four_week_rate', 11, 2)->nullable();
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
        Schema::dropIfExists('product_alternate_rates');
    }
};
