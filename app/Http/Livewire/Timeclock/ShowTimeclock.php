<?php

namespace App\Http\Livewire\Timeclock;

use App\Models\User;
use App\Models\Timeclock\TimeclockEntry;
use App\Models\Timeclock\TimeclockEntryType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;


class ShowTimeclock extends Component
{

    public ?int $currentUserIndex = null;
    public Collection $timeclockUsers;
    public string $query = '';
    public ?int $timeclockEntryType = null;
    public string $timezone = 'America/Toronto';
    public array $formatedTimeclockEntry = [];


    public function clockInOrOut(User $user)
    {
        $entry = new TimeclockEntry;
        $entry->entryType()->associate($this->timeclockEntryType);
        $entry->user()->associate($user);
        $entry->is_start_time = ! $this->wasLastEntryAStartTime($user);
        
        $entry->save();

        $queryString = ($this->query !== '')
            ? ['name', 'like', '%' . $this->query . '%']
            : null;             

        $this->timeclockUsers = $this->getTimeclockUsers($queryString);

        $this->getArrayForGoogleChartTimeline();
        
        $this->dispatchBrowserEvent('clockInOrOutCompleted');

    }

    protected function getArrayForGoogleChartTimeline()
    {

        foreach ($this->timeclockUsers as $key => $user) {

            // initialize variable we will need
            $formatedTimeclockEntry = [];
            $i = 0;

            // Loop through timeclock entries to create array to feed to google charts timeline
            foreach ($user->timeclockEntries->sortBy('created_at') as $entry) {

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

            // If there is no final clock out then set a dummy clock out to now
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

            $this->formatedTimeclockEntry[$key] = $formatedTimeclockEntry;

        }

    }

    protected function getClockOutOrMidnight($clockInTimestamp, $clockOutTimestamp)
    {
        // If the date is not the same then add extra entries between clock in and out
        $localClockIn = Carbon::createFromTimestampMs($clockInTimestamp, $this->timezone);
        $localMidnight = Carbon::createFromTimestampMs($clockInTimestamp, $this->timezone)->endOfDay();
        $difference = $localClockIn->diffInSeconds($clockOutTimestamp);
        $secondsToMidnight = $localClockIn->diffInSeconds($localMidnight);

        if ($difference > $secondsToMidnight) {
            return $localMidnight;
        } else {
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

    protected function getTimeclockUsers($whereClause = false)
    {
        return User::select(['id', 'name'])
            ->when($whereClause, function ($query, $whereClause) {
                $query->where( 'name', 'like', '%' . $this->query . '%' );
            })
            ->with(['timeclockEntries' => function ($query) {
                $query->where('timeclock_entry_type_id', $this->timeclockEntryType);
            }])
            ->orderBy('name')
            ->get();
    }

    public function mount()
    {

        $this->timeclockEntryType = TimeclockEntryType::firstWhere('name', 'Worked')->id;

        $this->timeclockUsers = $this->getTimeclockUsers();

        $this->getArrayForGoogleChartTimeline();
    }

    public function render()
    {
        return view('livewire.timeclock.show-timeclock');
    }

    public function updatedQuery()
    {
        $this->timeclockUsers = $this->getTimeclockUsers( ['name', 'like', '%' . $this->query . '%'] );

        $this->getArrayForGoogleChartTimeline();
    }

    protected function wasLastEntryAStartTime(User $user)
    {
        $lastEntry = $user->timeclockEntries()
            ->where('timeclock_entry_type_id', $this->timeclockEntryType)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (! $lastEntry) {
            return false;
        }

        return $lastEntry->is_start_time;
    }

}
