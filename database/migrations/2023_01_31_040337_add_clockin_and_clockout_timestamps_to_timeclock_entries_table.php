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
        Schema::table('timeclock_entries', function (Blueprint $table) {
            $table->timestamp('clock_in_at')->nullable()->after('user_id');
            $table->timestamp('clock_out_at')->nullable()->after('clock_in_at');
            $table->dropColumn('is_start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timeclock_entries', function (Blueprint $table) {
            $table->dropColumn(['clock_in_at', 'clock_out_at']);
            $table->boolean('is_start_time');
        });
    }
};
