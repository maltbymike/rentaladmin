<x-app-layout>
    <x-slot name="header">
        <x-page-title>{{ __('Upload Vault Profiles') }}</x-page-title>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2">
        
        <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
        
            @csrf

            <fieldset>

                <legend>Upload Profiles</legend>

                <input type="file" name="file" />

                <input type="hidden" name="collection" value="moneris_vault_profiles" />

                <x-jet-button type="submit">Upload</x-jet-button>
            
            </fieldset>
        
        </form>

        <form method="post">

            @csrf

            <fieldset>

                <legend>Uploaded Files</legend>

                <select name="file">
            
                    @foreach($existingFiles as $file)

                        <option value="{{ $file->id }}">{{ $file->file_name }}: ({{ $file->created_at }})</option>
                    
                    @endforeach
                
                </select>
            
            </fieldset>

        </form>
    
    </div>

</x-app-layout>