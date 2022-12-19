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
        Schema::table('moneris_tokens', function (Blueprint $table) {
            $table->string('exp_date', 4)
                ->after('masked_pan')
                ->nullable();

            $table->string('crypt_type', 1)
                ->after('exp_date')
                ->nullable();

            $table->string('avs_street_number', 19)
                ->after('crypt_type')
                ->nullable();

            $table->string('avs_street_name', 19)
                ->after('avs_street_number')
                ->nullable();
            
            $table->string('avs_zipcode', 9)
                ->after('avs_street_name')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moneris_tokens', function (Blueprint $table) {
            $table->dropColumn([
                'exp_date',
                'crypt_type',
                'avs_street_number',
                'avs_street_name',
                'avs_zipcode',
            ]);
        });
    }
};
