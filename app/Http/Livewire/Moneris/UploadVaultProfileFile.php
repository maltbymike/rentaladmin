<?php

namespace App\Http\Livewire\Moneris;

use App\Http\Livewire\Tools\UploadFile;
use App\Jobs\Moneris\ProcessVaultProfilesCsvChunkJob;
use App\Models\Upload;

use Illuminate\Support\Facades\Storage;

use Livewire\Component;

class UploadVaultProfileFile extends UploadFile
{
    
    protected $rules = [
        'file' => 'file|mimes:csv,txt|max:5120',
    ];

    public function uploadMonerisVaultProfileFile()
    {

        $this->validateOnly('file');

        $this->save('moneris', 'moneris_vault_profiles');
    }

    public function queueVaultProfilesForProcessing(Upload $upload)
    {

        // TODO - Add Authorization

        // Get filename
        $file = Storage::disk(config('app.uploads.disk'))->get($upload->path);

        // Split file into an array of lines
        $data = preg_split("/((\r?\n)|(\r\n?))/", $file);

        // Split the data into chunks
        foreach(array_chunk($data, 100) as $key => $chunk) {

            // Add the chunked content
            $content = implode(PHP_EOL, $chunk);

            // Set the output file name
            $fileName = "moneris/chunk/vault-chunk-{$key}.csv";

            // Save the chunked file
            Storage::disk(config('app.uploads.disk'))->put($fileName, $content);

            // Queue the job for processing
            ProcessVaultProfilesCsvChunkJob::dispatch($fileName);

        }        
        
        // Flash success message
        session()->flash('success', 'The file has been queue for processing'); 

        return redirect()->back();

    }

    public function render()
    {
        return view('livewire.moneris.upload-vault-profile-file', [
            'vault_file' =>
                Upload::where('collection', 'moneris_vault_profiles')->first()
        ]);
    }
}
