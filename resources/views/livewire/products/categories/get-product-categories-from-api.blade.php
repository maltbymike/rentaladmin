<div>

    <x-slot name="header">
        <x-page-title>Get Product Categories From Wordpress API</x-page-title>
    </x-slot>

    <x-jet-button
        wire:click="getProductCategories"
        wire:loading.class="opacity-50"
        wire:target="getProductCategories"
        class="mb-8">
        Get Product Categories
    </x-jet-button>

    <section 
        wire:loading.class="opacity-50"
        wire:target="getProductCategories"
        class="grid grid-cols-9 gap-3 bg-gray-100 p-3">
    
        @foreach($categoriesByStatus as $status => $categories)

            <div x-data="{ open: false }" class="contents">

                <x-jet-button x-on:click="open = ! open" class="col-span-full">
                    @if ($status === 'added') 
                        Added ({{ $categoriesByStatus['added']->count() }})
                    @elseif ($status === 'updated') 
                        Updated ({{ $categoriesByStatus['updated']->count() }})
                    @elseif ($status === 'toDelete') 
                        To Delete ({{ $categoriesByStatus['toDelete']->count() }})
                    @endif    
                </x-jet-button>

                <div x-show="open" class="contents">
                
                    <div class="col-span-3 font-bold">Name</div>
                    <div class="text-center font-bold">Category ID</div>
                    <div class="col-span-3 font-bold">Parent</div>
                    <div class="font-bold">Created At</div>
                    <div class="font-bold">Updated At</div>
                    
                    @foreach($categories as $category)
                        <div class="col-span-3">{!! $category->name !!}</div>
                        <div class="text-center">{{ $category->id }}</div>
                        <div class="col-span-3">{!! $category->parent->name ?? '' !!}</div>
                        <div>{{ $category->created_at }}</div>
                        <div>{{ $category->updated_at }}</div>
                    @endforeach
                
                </div>

            </div>

        @endforeach
    
    </section>

</div>
