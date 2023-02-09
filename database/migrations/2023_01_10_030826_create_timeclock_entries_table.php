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
        Schema::create('timeclock_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timeclock_entry_type_id')->constrained('timeclock_entry_types');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('is_start_time');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('replaced_by_timeclock_entry_id')->nullable()->constrained('timeclock_entries');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timeclock_entries');
    }
};
