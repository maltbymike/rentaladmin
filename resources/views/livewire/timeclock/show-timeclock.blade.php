<div>

    <div class="flex justify-center -m-3 bg-orange-500 text-white">
        <x-tools.show-current-date-and-time class="text-5xl flex flex-col items-center justify-center py-6 px-16" />
    </div>

    @if($currentTimeclockUser === null)
        <livewire:timeclock.show-timeclock-users />
    @endif

    @if($currentUserIndex === null)

        <input 
            type="text"
            list="users"
            class="mt-6 w-full rounded-full"
            placeholder="Search for User..."
            wire:model="query"
            />

        <div class="mt-6 flex flex-wrap items-stretch justify-center gap-3">
            
            @foreach ($timeclockUsers as $key => $user)

                <button 
                    class="front p-2 w-1/3 sm:w-1/4 md:w-1/6 lg:w-[12.5%] flex flex-col items-center cursor-pointer border rounded-xl shadow-xl hover:bg-orange-50 active:bg-orange-500 focus:bg-orange-50 focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                    wire:click="$set('currentUserIndex', {{ $key }})"
                    >

                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover">
                    <p class="text-center">{{ $user->name }}</p>

                </button>

            @endforeach
        
        </div>

    @endif

    @if($currentUserIndex !== null)

        <div 
            x-data="{ chartData: @entangle('formatedTimeclockEntry') }"
            class="mt-6 grid grid-cols-1 md:grid-cols-3 items-center gap-6 p-10"
            >
            
            <div class="flex flex-col md:flex-row items-center gap-3 border">
                <img src="{{ $timeclockUsers[$currentUserIndex]->profile_photo_url }}" alt="{{ $timeclockUsers[$currentUserIndex]->name }}" class="rounded-full h-20 w-20 object-cover">
                <p class="text-xl">{{ $timeclockUsers[$currentUserIndex]->name }}</p>
            </div>

            <div 
                class="col-span-1 md:col-span-2" 
                x-init="drawChart(chartData[{{ $currentUserIndex }}])"
                @clock-in-or-out-completed.camel.window="drawChart(chartData[{{ $currentUserIndex }}])"
                >
    
                <!-- Placeholder for chart -->
                <div id="timeline"></div>

            </div>
            
            <button class="md:col-start-2 py-6 border rounded-full text-xl cursor-pointer shadow-xl hover:bg-orange-100 active:bg-orange-500 focus:bg-orange-100 focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                wire:click="clockInOrOut({{ $timeclockUsers[$currentUserIndex]->id }})"
                >
                @if ($timeclockUsers[$currentUserIndex]->timeclockEntries->last())
                    {{ $timeclockUsers[$currentUserIndex]->timeClockEntries->last()->is_start_time 
                        ? "Clock Out" 
                        : "Clock In" }}
                @else
                    Clock In
                @endif
            </button>
        </div>

    @endif

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['timeline']});

        function drawChart(chartData) {
            
            var container = document.getElementById('timeline');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn({ type: 'string', id: 'Day of Week' });
            dataTable.addColumn({ type: 'string', id: 'Dummy Bar Label' });
            dataTable.addColumn({ type: 'string', role: 'tooltip' });
            dataTable.addColumn({ type: 'string', id: 'style', role: 'style'});
            dataTable.addColumn({ type: 'datetime', id: 'Clock In' });
            dataTable.addColumn({ type: 'datetime', id: 'Clock Out' });

            dataRows = chartData.map(function(data) {
                return [
                    data.in.day,
                    null,
                    data.in.hour + ":" + data.in.minute.toString().padStart(2, '0') + " - " + data.out.hour + ":" + data.out.minute.toString().padStart(2, '0'),
                    data.out.color,
                    new Date(0, 0, 0, data.in.hour, data.in.minute),
                    new Date(0, 0, 0, data.out.hour, data.out.minute),
                ];
            });

            dataTable.addRows(dataRows);

            var options = {
                timeline: {
                    rowLabelStyle: {
                        fontName: 'Nunito,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji"',
                        fontSize: 10,
                    },
                    barLabelStyle: {
                        fontName: 'Nunito,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji"',
                        fontSize: 10,
                    }
                },
                // Count unique clock in days and set height of chart
                height: new Set(chartData.map(value => value.in.day)).size * 35 + 50,
                
            };
            chart.draw(dataTable, options);

        }
    </script>

</div>
