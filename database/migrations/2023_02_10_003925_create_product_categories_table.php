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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wp_id')->unique();
            $table->string('name', 256);
            $table->bigInteger('wp_parent_id')->nullable();
            $table->timestamps();
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->foreign('wp_parent_id')->references('wp_id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};
