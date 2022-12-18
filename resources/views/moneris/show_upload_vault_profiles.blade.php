<x-app-layout>
    <x-slot name="header">
        <x-page-title>{{ __('Upload Vault Profiles') }}</x-page-title>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        
        <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data" class="p-3 border rounded-lg">
        
            @csrf

            <fieldset>

                <legend class="font-bold">Upload Profiles</legend>

                <input type="file" name="file" class="border p-2" />

                <input type="hidden" name="collection" value="moneris_vault_profiles" />

                <x-jet-button type="submit" class="ml-3">Upload</x-jet-button>
            
            </fieldset>
        
        </form>

        <form action="{{ route('moneris.processVaultProfiles') }}" method="post" class="p-3 border rounded-lg">

            @csrf

            <fieldset>

                <legend class="font-bold">Process Uploaded Files</legend>

                <select name="file">
            
                    @foreach($existingFiles as $file)

                        <option value="{{ $file->file_hash }}">{{ $file->file_name }}: ({{ $file->created_at }})</option>
                    
                    @endforeach
                
                </select>

                <x-jet-button type="submit" class="ml-3">Process File</x-jet-button>
            
            </fieldset>

        </form>
    
    </div>

</x-app-layout>