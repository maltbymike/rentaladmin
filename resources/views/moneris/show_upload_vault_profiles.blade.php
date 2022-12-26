<x-app-layout>
    <x-slot name="header">
        <x-page-title>{{ __('Upload Vault Profiles') }}</x-page-title>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <div>

            <div class="col-span-full p-3 pb-0 font-bold text-gray-800 text-lg">Step 1:</div>
            
            <div class="p-3 border rounded-lg">
            
                <h2 class="text-gray-500 font-bold">Upload Profiles</h2>

                <livewire:moneris.upload-vault-profile-file />

            </div>
        
        </div>


        <div>

            <div class="col-span-full p-3 pb-0 font-bold text-gray-800 text-lg">Step 2:</div>

            <form action="{{ route('moneris.processVaultProfiles') }}" method="post" class="p-3 border rounded-lg">

                @csrf

                <fieldset>

                    <h2 class="text-gray-500 font-bold">Process Uploaded Files</h2>

                    <select name="file">
                
                        @foreach($existingFiles as $file)

                            <option value="{{ $file->file_hash }}">{{ $file->file_name }}: ({{ $file->created_at }})</option>
                        
                        @endforeach
                    
                    </select>

                    <x-jet-button type="submit" class="ml-3">Process File</x-jet-button>
                
                </fieldset>

            </form>

        </div>
    
        <div class="col-span-full p-3 pb-0 font-bold text-gray-800 text-lg">Step 3:</div>

        <div class="col-span-full p-3 border rounded-lg">
        
            <h2 class="text-gray-500 font-bold">Update Token Details from Vault</h2>
            
            <livewire:moneris.update-tokens-from-vault />
        
        </div>

    </div>

</x-app-layout>