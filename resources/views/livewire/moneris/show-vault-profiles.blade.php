<div>

    <x-flash-messages.message-block />

    @can('manage moneris vault tokens')
        <div class="w-full text-xs flex gap-3 p-3 bg-gray-50">
            
            <livewire:moneris.upload-vault-profile-file />
            
            <div class="ml-auto">

                <x-tools.delete-all-records-dropdown wire:click="deleteAllVaultRecords" />

            </div>

        </div>
    @endcan

    <div class="w-full text-xs flex gap-3 p-3">

        <div class="flex flex-col max-w-fit">
        
            <label for="show-expired">Expiry Date</label>
            <select id="show-expired" 
                class="py-0 pl-1 rounded-lg"
                wire:model="showExpired" 
                {{ $filterForDeletion ? 'disabled' : '' }}>
                
                <option value="1">Show All</option>
                <option value="2">Only Expired</option>
                <option value="3">Only Unexpired</option>
                <option value="4">Only No Expiry</option>
            </select>

        </div>

        <div class="flex flex-col max-w-fit">
        
            <label for="show-tokens-in-por">Match POR Tokens</label>
            <select id="show-tokens-in-por"
                class="py-0 pl-1 rounded-lg"
                wire:model="matchPorTokens" 
                {{ $filterForDeletion ? 'disabled' : '' }}>

                <option value="1">Show All</option>
                <option value="2">Only Tokens in POR</option>
                <option value="3">Only Tokens not in POR</option>
            </select>

        </div>

        <div class="flex flex-col min-w-fit items-center">

            <label for="show-avs">Show AVS</label>
            <input type="checkbox"
                class="mt-1 rounded-full"
                wire:model="showAVS" />
            
        </div>

        @can('manage moneris vault tokens')
            
            @if($filterForDeletion)
            
                <x-tools.secondary-button
                    wire:click.prevent="filterForDeletion(false)"
                    wire:loading.attr="disabled"
                    wire:loading.target="filterForDeletion"
                    class="mt-auto ml-auto">
                    
                    Return to Lookup
                </x-tools.secondary-button>

                <div class="mt-auto" wire:loading.remove>
                    <livewire:moneris.delete-vault-profiles />
                </div>
            
            @else
                <x-tools.secondary-button 
                    wire:click.prevent="filterForDeletion" 
                    wire:loading.attr="disabled" 
                    wire:loading.target="filterForDeletion" 
                    class="mt-auto ml-auto">
                    
                    Filter for Deletion
                </x-tools.secondary-button>
            @endif
        
        @endcan

    </div>

    <div class="flex flex-col items-center justify-center w-full">
        <div class="p-36" wire:loading>
            <x-tools.loading-spinner />
        </div>
    </div>

    <div wire:loading.remove class="overflow-auto whitespace-nowrap p-3">

        {{ $profiles->links() }}

        <table class="w-full my-3">
            
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

        {{ $profiles->links() }}
    
    </div>

</div>
