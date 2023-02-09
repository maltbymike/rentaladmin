<div>

    <div class="flex justify-center -m-3 bg-orange-500 text-white">
        <x-tools.show-current-date-and-time class="text-5xl flex flex-col items-center justify-center py-6 px-16" />
    </div>

    <div 
        x-data="{ chartData: @entangle('formatedTimeclockEntry') }"
        class="mt-6 grid grid-cols-1 md:grid-cols-3 items-start gap-6 p-10"
        >
        
        <div class="flex flex-col md:flex-row items-center gap-3">
            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover">
            <p class="text-xl">{{ $user->name }}</p>
        </div>

        <!-- <x-jet-button class="py-6 border rounded-full text-xl cursor-pointer shadow-xl bg-gray-700 text-white hover:bg-orange-100 active:bg-orange-500 focus:bg-orange-100 focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" -->
        <x-jet-button class="py-6 rounded-full text-xl cursor-pointer shadow-xl justify-center"
            wire:click="clockInOrOut({{ $user->id }})"
            wire:loading.attr="disabled"
            wire:target="clockInOrOut"
            >
            @if ($isClockIn)
                Clock In
            @else
                Clock Out
            @endif
    
        </x-jet-button>
 
        <div 
            class="col-span-1 md:col-span-3"
            x-init="$wire.drawChart()"
            @draw-chart.camel.window="drawChart(chartData)"
            >
            <p class="text-xl">History</p>
            <!-- Placeholder for chart -->
            <div id="timeline"></div>

        </div>
        
    </div>

    @foreach($confirmations as $key => $confirmation)
        <x-jet-confirmation-modal wire:model="confirmations">
            <x-slot name="title"></x-slot>
            <x-slot name="content">{{ $confirmation['message'] }}</x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-tools.secondary-button wire:click.prevent="removeConfirmation({{$key}})">Cancel</x-tools.secondary-button>
                    <x-jet-danger-button wire:click.prevent="confirm({{$key}})">Delete Last Entry</x-jet-danger-button>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
    @endforeach

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
