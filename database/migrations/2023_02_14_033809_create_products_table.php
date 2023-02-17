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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wp_id')->nullable()->unique();
            $table->string('name', 150);
            $table->string('weblink', 256)->nullable();
            $table->foreignId('product_status_id')->nullable()->constrained();
            $table->foreignId('product_visibility_id')->nullable()->constrained();
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('sku', 20);
            $table->decimal('sell_price', 12, 3)->nullable();
            $table->decimal('two_hour_rate', 12, 3)->nullable();
            $table->decimal('four_hour_rate', 12, 3)->nullable();
            $table->decimal('daily_rate', 12, 3)->nullable();
            $table->decimal('weekly_rate', 12, 3)->nullable();
            $table->decimal('four_week_rate', 12, 3)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 6, 2)->nullable();
            $table->decimal('width', 6, 2)->nullable();
            $table->decimal('height', 6, 2)->nullable();
            $table->foreignId('product_shipping_class')->nullable()->constrained();
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
        Schema::dropIfExists('products');
    }
};
