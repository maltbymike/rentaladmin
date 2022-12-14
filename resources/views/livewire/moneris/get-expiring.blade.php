<div>

    <div class="flex items-center">

        <div class="grow">
        
            <x-jet-button 
                wire:click="getExpiring" 
                wire:loading.class="opacity-50"
                wire:target="getExpiring"
                class="my-3">

                Get Expiring Cards
            </x-jet-button>

            <div class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest opacity-50">
                {{ $isTestMode ? 'Test' : 'Live' }}
            </div>

        </div>


        @if($response)

            <div class="grow-0" x-data="{ open : false }">

                <x-jet-button x-on:click="open = ! open">Show Response</x-jet-button>

                <div x-show="open">

                    <div>Response Code: {{ $response['code'] }}</div>
                    <div>Message: {{ $response['message'] }}</div>
                    <div>Trans Date: {{ $response['trans_date'] }}</div>
                    <div>Trans Time: {{ $response['trans_time'] }}</div>
                    <div>Complete: {{ $response['complete'] }}</div>
                    <div>Timed Out: {{ $response['timed_out'] }}</div>
                    <div>Success: {{ $response['success'] }}</div>
                    <div>Payment Type: {{ $response['payment_type'] }}</div>
                
                </div>

            </div>

        @endif

    </div>
    
    @if($expiring)

        <div class="overflow-auto max-h-[90vh]">

            <table class="table-auto text-center">
                
                <thead class="bg-white sticky top-0 z-10">     

                    <tr>
                        <th class="bg-white sticky left-0 z-20">Token</th>
                        <th>Payment Type</th>
                        <th>Customer ID</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Note</th>
                        <th>Masked Pan</th>
                        <th>Exp Date</th>
                        <th>Crypt Type</th>
                        <th>AVS Street Number</th>
                        <th>AVS Streen Name</th>
                        <th>AVS Postal Code</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($expiring as $token)
                    <tr class="even:bg-slate-200">
                        <th class="bg-white sticky left-0">{{ $token['data_key'] }}</th>
                        <td>{{ $token['payment_type'] }}</td>
                        <td>{{ $token['cust_id'] }}</td>
                        <td>{{ $token['phone'] }}</td>
                        <td>{{ $token['email'] }}</td>
                        <td>{{ $token['note'] }}</td>
                        <td>{{ $token['masked_pan'] }}</td>
                        <td>{{ $token['expdate'] }}</td>
                        <td>{{ $token['crypt_type'] }}</td>
                        <td>{{ $token['avs_street_number'] }}</td>
                        <td>{{ $token['avs_street_name'] }}</td>
                        <td>{{ $token['avs_zipcode'] }}</td>
                    </tr>        
                    @endforeach

                </tbody>

            </table>
        
        </div>

    @endif

</div>