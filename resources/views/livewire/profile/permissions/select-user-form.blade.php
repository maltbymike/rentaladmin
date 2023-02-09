<x-jet-form-section submit="updateUser">
    <x-slot name="title">
        {{ __('Select User') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Choose a user to manage.') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-full grid grid-cols-1 gap-3" x-data="{ open: false }">

            <div x-show="! open" class="text-lg font-medium text-gray-900 w-full flex items-center gap-3">
                <img src="{{ $userToModify->profile_photo_url }}" alt="{{ $userToModify->name }}" class="rounded-full h-20 w-20 object-cover">
                {{ $userToModify->name }}
                <button wire:click.prevent x-on:click="open = true"><x-svg.icons.pen-to-square class="w-4"/></button>
            </div>

            <div x-cloak x-show="open" class="contents">

                <input 
                    type="text"
                    list="users"
                    class="w-full rounded-xl"
                    placeholder="Search for User..."
                    wire:model="query"
                    x-on:focus="open = true"
                    />

                <div class="flex overflow-x-auto gap-3">
                    @foreach ($users as $user)
                        <a href="{{ route('profile.permissions.show', ['user' => $user->id]) }}" class="p-2 flex flex-col items-center cursor-pointer border rounded-xl w-1/6 shrink-0">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover">
                            <p class="text-center">{{ $user->name }}</p>
                        </a>
                    @endforeach
                </div>

                <x-jet-danger-button x-on:click="open = false" class="w-fit justify-self-end">Cancel</x-jet-danger-button>
            
            </div>

        </div>

    </x-slot>

</x-jet-form-section>