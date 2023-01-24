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
    public User $user;
    public string $timezone = 'America/Toronto';

    public ?TimeclockEntry $lastEntry;
    protected int $minimumDifferenceBetweenTimeclockEntries = 5 * 60;

    protected $listeners = [
        'confirmDeleteLastTimeclockEntry' => 'deleteLastTimeclockEntry',
        'confirmationCancelled' => 'processCancelledConfirmation',
    ];

    public function clockInOrOut()
    {
        // TODO check permissions
        // TODO prompt for confirmation if clocking in or out within a set period of time from the last entry
        // TODO prompt if clockout was more then set period of time from last clockin

        $isLastEntryAStartTime = $this->wasLastEntryAStartTime();

        if ($this->lastEntry === null || $this->lastEntry->created_at->diffInSeconds(now()) > $this->minimumDifferenceBetweenTimeclockEntries) {

            // If last timeclock entry is more than the minimum difference between entries then persist the entry
            $this->persistNewTimeclockEntry($isLastEntryAStartTime);

        } else {

            // If timeclock entry is less than the minimum difference then prompt for confirmation
            $lastEntryCreatedAt = $this->lastEntry->created_at->setTimezone($this->timezone)->format('h:ia');
            $this->emit('sendConfirmation', "Your last timeclock entry was at $lastEntryCreatedAt.  Would you like to delete your previous timeclock entry?", 'confirmDeleteLastTimeclockEntry');

        }

    }

    public function deleteLastTimeclockEntry()
    {
        $this->lastEntry->delete();

        $this->user->refresh();

        $this->drawChart();
    }

    public function drawChart()
    {
        $this->getArrayForGoogleChartTimeline();

        $this->dispatchBrowserEvent('drawChart');
    }

    protected function getArrayForGoogleChartTimeline()
    {

        // initialize variable we will need
        $formatedTimeclockEntry = [];
        $i = 0;

        // Loop through timeclock entries to create array to feed to google charts timeline
        foreach ($this->user->timeclockEntries->sortBy('created_at') as $entry) {

            // Apply Timezone to created_at timestamp
            $localtime = $entry->created_at->setTimezone($this->timezone);

            // Entry is a clock in
            if ($entry->is_start_time) {

                // Check if the current formatedTimeclockEntry has a clockIn value
                // Increment array key if there is already an clockIn value
                if (isset($formatedTimeclockEntry[$i]['in']['timestamp'])) {
                    $i++;
                }

                // Set clockIn properties
                $formatedTimeclockEntry[$i]['in'] = $this->getFormatedTimestampArray($localtime);

            // Entry is a clock out
            } else {

                // Check if the current formatedTimeclockEntry has a clockOut value
                // Increment array key if there is already a clockOut value
                if (isset($formatedTimeclockEntry[$i]['out']['timestamp'])) {
                    $i++;
                }

                // If the date is not the same then add extra entries between clock in and out
                do {
                    
                    // If clockout date is past clock in date get midnight otherwise get clock out time
                    $clockOutOrMidnight = $this->getClockOutOrMidnight($formatedTimeclockEntry[$i]['in']['timestamp'], $localtime);

                    // Set clockOut time
                    $formatedTimeclockEntry[$i]['out'] = $this->getFormatedTimestampArray($clockOutOrMidnight);
                    
                    if ($localtime !== $clockOutOrMidnight) {
                        
                        $i++;

                        // Set clockIn to 00:00:00
                        $formatedTimeclockEntry[$i]['in'] = $this->getFormatedTimestampArray($clockOutOrMidnight->addSecond());
                    
                    }                        
                    
                } while ($localtime !== $clockOutOrMidnight);

            }
            
        }

        // If there is no final clock out then set a dummy clock out to now to allow for visualization
        if ( ( ! isset( $formatedTimeclockEntry[$i]['out'] ) ) && ( isset( $formatedTimeclockEntry[$i]['in'] ) ) ) {

            $currentLocalTime = now($this->timezone);

            // If the date is not the same then add extra entries between clock in and dummy clock out
            do {

                // If clockout date is past clock in date get midnight otherwise get clock out time
                $dummyClockOutOrMidnight = $this->getClockOutOrMidnight($formatedTimeclockEntry[$i]['in']['timestamp'], $currentLocalTime);

                // Set clockOut time
                $formatedTimeclockEntry[$i]['out'] = $this->getFormatedTimestampArray($dummyClockOutOrMidnight, '#0284C7');
                
                if ($currentLocalTime !== $dummyClockOutOrMidnight) {
                    
                    $i++;

                    // Set clockIn to 00:00:00
                    $formatedTimeclockEntry[$i]['in'] = $this->getFormatedTimestampArray($dummyClockOutOrMidnight->addSecond(), '#0284C7');
                
                }                        
                
            } while ($currentLocalTime !== $dummyClockOutOrMidnight);

        }

        $this->formatedTimeclockEntry = $formatedTimeclockEntry;

    }

    protected function getClockOutOrMidnight($clockInTimestamp, $clockOutTimestamp)
    {
        // If the date is not the same then add extra entries between clock in and out
        $localClockIn = Carbon::createFromTimestampMs($clockInTimestamp, $this->timezone);
        $localMidnight = Carbon::createFromTimestampMs($clockInTimestamp, $this->timezone)->endOfDay();
        $difference = $localClockIn->diffInSeconds($clockOutTimestamp);
        $secondsToMidnight = $localClockIn->diffInSeconds($localMidnight);

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

    protected function getFormatedTimestampArray($timestamp, $color = '#0F172A')
    {
        return [
            'timestamp' => $timestamp->getTimestampMs(),
            'day' => $timestamp->format('D M j'),
            'hour' => $timestamp->hour,
            'minute' => $timestamp->minute,
            'second' => $timestamp->second,
            'color' => $color,
        ];
    }

    protected function loadTimeclockEntries() {

        $this->user->load(['timeclockEntries' => function ($query) {
            $query->where('timeclock_entry_type_id', $this->timeclockEntryType);
        }]);

    }

    public function mount(User $user) 
    {
        
        $this->timeclockEntryType = TimeclockEntryType::firstWhere('name', 'Worked')->id;

        $this->loadTimeclockEntries();

        $this->getArrayForGoogleChartTimeline();
    
    }

    public function persistNewTimeclockEntry($isLastEntryAStartTime = null)
    {
        if ($isLastEntryAStartTime === null) {
            $isLastEntryAStartTime = $this->wasLastEntryAStartTime();
        }

        $entry = new TimeclockEntry;
        $entry->entryType()->associate($this->timeclockEntryType);
        $entry->user()->associate($this->user);
        $entry->is_start_time = ! $isLastEntryAStartTime;

        $entry->save();

        $this->loadTimeclockEntries();

        $this->drawChart();
        
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

    protected function wasLastEntryAStartTime()
    {
        $lastEntry = $this->user->timeclockEntries()
            ->where('timeclock_entry_type_id', $this->timeclockEntryType)
            ->orderBy('created_at', 'desc')
            ->first();

        $this->lastEntry = $lastEntry;
        
        if (! $lastEntry) {
            return false;
        }

        return $lastEntry->is_start_time;
    }
}
