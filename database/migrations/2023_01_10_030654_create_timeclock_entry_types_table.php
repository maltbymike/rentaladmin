<?php

use App\Models\Timeclock\TimeclockEntryType;
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
        Schema::create('timeclock_entry_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        $worked = new TimeClockEntryType;
        $worked->name = "Worked";
        $worked->save();

        $scheduled = new TimeClockEntryType;
        $scheduled->name = "Scheduled";
        $scheduled->save();

        $timeOff = new TimeClockEntryType;
        $timeOff->name = "Time Off";
        $timeOff->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timeclock_entry_types');
    }
};
