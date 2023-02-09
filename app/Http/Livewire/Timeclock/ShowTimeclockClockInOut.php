<?php

namespace App\Http\Livewire\Timeclock;

use App\Http\Livewire\Traits\WithConfirmation;
use App\Models\User;
use App\Models\Timeclock\TimeclockEntry;
use App\Models\Timeclock\TimeclockEntryType;
use Carbon\Carbon;
use Livewire\Component;

class ShowTimeclockClockInOut extends Component
{
    use WithConfirmation;

    public array $formatedTimeclockEntry = [];

    public bool $isClockIn = true;

    public ?TimeclockEntry $lastEntry;

    protected int $minimumDifferenceBetweenTimeclockEntries = 5 * 60;

    public ?int $timeclockEntryTypeId;

    public string $timezone = 'America/Toronto';

    public User $user;

    protected $listeners = [
        'confirmDeleteLastTimeclockEntry' => 'deleteLastTimeclockEntry',
        'confirmationCancelled' => 'processCancelledConfirmation',
    ];

    public function clockInOrOut()
    {
        // TODO check permissions

        $lastEntry = $this->user->timeclockEntries->last();

        if ($lastEntry) {

            if ($lastEntry->clock_out_at !== null) {

                if ($this->isClockPastMinimumInterval($lastEntry->clock_out_at)) {

                    $this->clockIn();

                }

            } else {

                if ($this->isClockPastMinimumInterval($lastEntry->clock_in_at)) {

                    $this->clockOut($lastEntry);

                }

            }

        } else {

            $this->clockIn();

        }

        $this->loadTimeclockEntries();

        $this->drawChart();

    }

    public function clockIn($timestamp = null)
    {

        if ($timestamp === null) {
            $timestamp = now();
        }

        $entry = new TimeclockEntry;
        $entry->clock_in_at = $timestamp;
        $entry->entryType()->associate($this->timeclockEntryTypeId);

        $this->user->timeclockEntries()->save($entry);
    
    }

    public function clockOut(TimeclockEntry $lastEntry, $timestamp = null)
    {
        if ($timestamp === null) {
            $timestamp = now();
        }

        $lastEntry->clock_out_at = $timestamp;
        $lastEntry->save();
    }

    public function deleteLastTimeclockEntry()
    {
        if ($this->isClockIn) {
            $this->user->timeclockEntries->last()->clock_out_at = null;
            $this->user->timeclockEntries->last()->save();
        } else {
            $this->user->timeclockEntries->last()->forceDelete();
        }

        $this->loadTimeclockEntries();
    }

    public function drawChart()
    {
        $this->getArrayForGoogleChartTimeline();

        $this->dispatchBrowserEvent('drawChart');
    }

    protected function getArrayForGoogleChartTimeline()
    {

        // initialize variable we will need
        $formatedEntry = [];
        $i = 0;

        // Loop through timeclock entries to create array to feed to google charts timeline
        foreach ($this->user->timeclockEntries->sortBy('created_at') as $entry) {

            // Apply Timezone to created_at timestamp
            $localClockInAt = $entry->clock_in_at->setTimezone($this->timezone);

            if ($entry->clock_out_at) {
                $localClockOutAt = $entry->clock_out_at->setTimezone($this->timezone);
                $color = null;
            } else {
                $localClockOutAt = now($this->timezone);
                $color = '#0284C7';
            }

            $formatedEntry[$i]['in'] = $this->getFormatedTimestampArray($localClockInAt);

            // If the date is not the same then add extra entries between clock in and out
            do {

                // If clockout date is past clock in date get midnight otherwise get clock out time
                $clockOutOrMidnight = $this->getClockOutOrMidnight($localClockInAt, $localClockOutAt);
                
                // Set clockOut time
                $formatedEntry[$i]['out'] = $this->getFormatedTimestampArray($clockOutOrMidnight, $color);

                if ($localClockOutAt !== $clockOutOrMidnight) {

                    $i++;

                    // Set clockIn to 00:00:00
                    $localClockInAt = $clockOutOrMidnight->addSecond();
                    $formatedEntry[$i]['in'] = $this->getFormatedTimestampArray($localClockInAt);

                }

            } while ($localClockOutAt !== $clockOutOrMidnight && $i < 10);

            $formatedEntry[$i]['out'] = $this->getFormatedTimestampArray($localClockOutAt, $color);

            $i++;

        }

        $this->formatedTimeclockEntry = $formatedEntry;
        
    }

    protected function getClockOutOrMidnight($clockInTimestamp, $clockOutTimestamp)
    {

        // If the date is not the same then add extra entries between clock in and out
        $localMidnight = Carbon::createFromTimestampMs($clockInTimestamp->getTimestampMs(), $this->timezone)->endOfDay();
        $difference = $clockInTimestamp->diffInSeconds($clockOutTimestamp);
        $secondsToMidnight = $clockInTimestamp->diffInSeconds($localMidnight);

        if ($difference < 60) {
            
            // If there is less than 1 minute difference between clock in and out then add 1 minute to clockout to allow for visualization
            return $clockOutTimestamp->addMinute();
        
        } elseif ($difference > $secondsToMidnight) {

            // If there is more time between clock in and out then the time between clockin and midnight then return midnight
            return $localMidnight;

        } else {

            // Otherwise return clock out time
            return $clockOutTimestamp;

        }

    }

    protected function getFormatedTimestampArray($timestamp, $color = null)
    {
        if ($timestamp === null) {
            return null;
        }

        if ($color === null) {
            $color = '#0F172A';
        }

        return [
            'timestamp' => $timestamp->getTimestampMs(),
            'day' => $timestamp->format('D M j'),
            'hour' => $timestamp->hour,
            'minute' => $timestamp->minute,
            'second' => $timestamp->second,
            'color' => $color,
        ];
    }

    protected function isClockIn()
    {
        if ($this->user->timeclockEntries->last() && $this->user->timeclockEntries->last()->clock_out_at === null) {
            return false;
        } else {
            return true;
        }
    }

    protected function isClockPastMinimumInterval($timestamp)
    {

        if ($timestamp->diffInSeconds(now()) < $this->minimumDifferenceBetweenTimeclockEntries) {

            $lastEntryTime = $timestamp->setTimezone($this->timezone)->format('h:ia');
            $this->emit('sendConfirmation', "Your last timeclock entry was at $lastEntryTime.  Would you like to delete your previous timeclock entry?", 'confirmDeleteLastTimeclockEntry');

            return false;

        }

        return true;
    
    }

    protected function loadTimeclockEntries() {

        $this->user->load(['timeclockEntries' => function ($query) {
            $query->where('timeclock_entry_type_id', $this->timeclockEntryTypeId);
        }]);

        $this->isClockIn = $this->isClockIn();

    }

    public function mount(User $user) 
    {
        
        $this->timeclockEntryTypeId = TimeclockEntryType::firstWhere('name', 'Worked')->id;

        $this->loadTimeclockEntries();

        $this->getArrayForGoogleChartTimeline();
    
    }

    public function processCancelledConfirmation($callback) 
    {
        switch ($callback) {
            case 'confirmDeleteLastTimeclockEntry':
                $this->drawChart();
                break;
        }
    }

    public function render()
    {
        return view('livewire.timeclock.show-timeclock-clock-in-out');
    }

}
