<div>

    <x-jet-button
        wire:click="getProductCategories"
        wire:loading.class="opacity-50"
        wire:target="getProductCategories"
        class="my-3">
        Get Product Categories From Wordpress API
    </x-jet-button>

    <table class="table-auto">

        <thead>
            <tr>
                <th>Name</th>
                <th>Category ID</th>
                <th>Parent ID</th>
            </tr>
        </thead>

        <tbody>

            @if($categories)
            @foreach($categories as $category)
            
                <tr>
                    <td>{{ $category['name'] }}</td>
                    <td>{{ $category['id'] }}</td>
                    <td>{{ $category['parent'] }}</td>
                </tr>

            @endforeach
            @endif

        </tbody>

    </table>

</div>
