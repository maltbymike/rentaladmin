<div>
    
    <div class="flex justify-center -m-3 bg-orange-500 text-white">
        <x-tools.show-current-date-and-time class="text-5xl flex flex-col items-center justify-center py-6 px-16" />
    </div>

    <input 
        type="text"
        list="users"
        class="mt-6 w-full rounded-full"
        placeholder="Search for User..."
        wire:model="query"
        />

    <div class="mt-6 flex flex-wrap items-stretch justify-center gap-3">
        
        @foreach ($timeclockUsers as $key => $user)

            <a 
                class="front p-2 w-1/3 sm:w-1/4 md:w-1/6 lg:w-[12.5%] flex flex-col items-center cursor-pointer border rounded-xl shadow-xl hover:bg-orange-50 active:bg-orange-500 focus:bg-orange-50 focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                href="{{ route('timeclock', ['user' => $user->id]) }}"
                >

                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover">
                <p class="text-center">{{ $user->name }}</p>

            </a>

        @endforeach
    
    </div>

</div>
