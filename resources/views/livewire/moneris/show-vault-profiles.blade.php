<div>

    <div class="w-full text-xs flex gap-3 py-3">

        <div class="flex flex-col max-w-fit">
        
            <label for="show-expired">Expiry Date</label>
            <select wire:model="showExpired" id="show-expired" class="py-0 pl-1 rounded-lg">
                <option value="1">Show All</option>
                <option value="2">Only Expired</option>
                <option value="3">Only Unexpired</option>
            </select>

        </div>

        <div class="flex flex-col min-w-fit">

            <label for="show-avs">AVS</label>
            <x-jet-button wire:click="$toggle('showAVS')" class="py-1 {{ $showAVS ? '' : 'opacity-25' }}">Show</x-jet-button>
            
        </div>

        <div class="ml-auto">

            <x-jet-dropdown align="right" width="w-60">
                
                <x-slot name="trigger">
                    
                    <x-jet-secondary-button class="py-1">Clear Records</x-jet-secondary-button>
                    
                </x-slot>

                <x-slot name="content">

                    <div class="px-3 py-16 flex items-center justify-center">

                        <x-jet-danger-button wire:click="deleteAllVaultRecords">Delete All Records</x-jet-danger-button>

                    </div>

                </x-slot>
            
            </x-jet-dropdown>
        
        </div>
    
    </div>

    <div class="overflow-auto whitespace-nowrap">
        <table class="w-full">
            
            <thead>
                
                <tr>
                
                    <th class="text-left">Data Key</th>
                    <th class="text-center px-2">Cust ID</th>
                    <th class="text-center px-2">Email</th>
                    <th class="text-center px-2">Phone</th>
                    <th class="text-center px-2">Note</th>
                    <th class="text-center px-2">Masked Pan</th>
                    <th class="text-center px-2">Exp Date</th>
                    <th class="text-center px-2">Crypt Type</th>
                    
                    @if ($showAVS)
                    <th class="text-center px-2">AVS Street Number</th>
                    <th class="text-center px-2">AVS Street Name</th>
                    <th class="text-center px-2">AVS Zipcode</th>
                    @endif

                    <th class="text-center px-2">Date Created</th>
                
                </tr>
            
            </thead>

            <tbody>

                @foreach ($profiles as $profile)

                    <tr class="odd:bg-gray-50">

                        <td class="text-left">{{ $profile->data_key }}</td>
                        <td class="text-center px-2">{{ $profile->cust_id }}</td>
                        <td class="text-center px-2">{{ $profile->email }}</td>
                        <td class="text-center px-2">{{ $profile->phone }}</td>
                        <td class="text-center px-2">{{ $profile->note }}</td>
                        <td class="text-center px-2">{{ $profile->masked_pan }}</td>
                        <td class="text-center px-2">{{ $profile->formattedExpDate() }}</td>
                        <td class="text-center px-2">{{ $profile->crypt_type }}</td>
                        
                        @if ($showAVS)
                        <td class="text-center px-2">{{ $profile->avs_street_number }}</td>
                        <td class="text-center px-2">{{ $profile->avs_street_name }}</td>
                        <td class="text-center px-2">{{ $profile->avs_zipcode }}</td>
                        @endif

                        <td class="text-center px-2">{{ $profile->created_at }}</td>
                    
                    </tr>
            
                @endforeach

            </tbody>
        
        </table>
    </div>

    {{ $profiles->links() }}

</div>
