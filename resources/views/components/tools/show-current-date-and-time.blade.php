@once 
    @push('scripts')
        <script>
            function showTime(){

                var date = new Date();
                
                const dateOptions = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
                const timeOptions = { hour: "numeric", minute: "numeric", second: "numeric" };
                var day = new Intl.DateTimeFormat("en-US", dateOptions).format(date);
                var time = new Intl.DateTimeFormat("en-US", timeOptions).format(date);
            
                document.getElementById("ClockDisplayTime").innerText = time;
                document.getElementById("ClockDisplayDate").innerText = day;
                
                setTimeout(showTime, 1000);
                
            }

            showTime();
        </script>    
    @endpush
@endonce

<div {{ $attributes }} onload="showtime()">
    <div id="ClockDisplayDate" class="text-center text-[.5em]"></div>
    <div id="ClockDisplayTime" class="text-center"></div>
</div>