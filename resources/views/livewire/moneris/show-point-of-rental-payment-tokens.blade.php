<div>

    <div class="p-3 mb-3 bg-gray-50 w-full flex gap-3">
        
        <livewire:moneris.upload-por-payments-file />

        <div class="ml-auto">
            <x-tools.delete-all-records-dropdown wire:click="deleteAllPorTokenRecords" />
        </div>  

    </div>

    <div class="overflow-auto whitespace-nowrap p-3">

        {{ $tokens->links() }}
    
        <table class="w-full my-3">
            
            <thead>
                
                <tr>
                
                    <th class="text-left">Token</th>
                    <th class="text-center px-2">Last Used</th>
                    <th class="text-center px-2">Use Count</th>
                    <th class="text-center px-2">Customer</th>
                                    
                </tr>
            
            </thead>

            <tbody>

                @foreach ($tokens as $token)

                    <tr class="odd:bg-gray-50">

                        <th class="text-left">{{ $token->por_token }}</th>
                        <td class="text-center px-2">{{ $token->date }}</td>
                        <td class="text-center px-2">{{ $token->use_count }}</td>
                        <td class="text-center px-2">
                            @if ($token->min_customer === $token->max_customer)
                                {{ $token->max_customer }}
                            @else
                                Multiple
                            @endif
                        </td>
                        
                    </tr>

                @endforeach

            </tbody>
        
        </table>

        {{ $tokens->links() }}
    </div>

</div>
