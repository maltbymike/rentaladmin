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
        Schema::create('product_alternate_rate_products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignId('product_alternate_rate_type_id')->constrained()->index('alternate_products_alternate_rate_type');
            $table->string('product_identifier', 50);
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
        Schema::dropIfExists('product_alternate_rate_products');
    }
};
