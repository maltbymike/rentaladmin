<?php

namespace App\Http\Livewire\Moneris;

use App\Http\Livewire\Tools\UploadFile;
use App\Jobs\Moneris\ProcessPorCustomerCardsFileChunkJob;
use App\Models\Upload;

use Illuminate\Support\Facades\Storage;

use Livewire\Component;

class UploadPorCustomerCardsFile extends UploadFile
{
    
    protected $rules = [
        'file' => 'file|mimes:csv,txt|max:5120',
    ];

    public function uploadPorCustomerCardsFile()
    {

        $this->validateOnly('file');

        $this->save('moneris', 'moneris_por_customer_cards');
    }

    public function queuePorCustomerCardsForProcessing(Upload $upload)
    {
        
        // Check authorization
        if (! auth()->user()->can('manage moneris vault tokens')) {
            
            session()->flash('failure', __('This user is not authorized to manage moneris vault tokens!'));

            return false;
        
        }
        
        // Get filename
        $file = Storage::disk(config('app.uploads.disk'))->get($upload->path);

        // Split file into an array of lines
        $data = preg_split("/\r\n|\n|\r/", $file);

        // Shift the header row out of the array
        $header = array_shift($data);

        // Split the data into chunks
        foreach (array_chunk($data, 100) as $key => $chunk) {
            
            // Start the file with a header row
            $content = $header . PHP_EOL;

            // Add the chunked content
            $content .= implode(PHP_EOL, $chunk);

            // Set the output file name
            $fileName = "moneris/chunk/por-customer-card-chunk-{$key}.csv";

            // Save the chunked file
            Storage::disk(config('app.uploads.disk'))->put($fileName, $content);

            // Queue the job for processing
            ProcessPorCustomerCardsFileChunkJob::dispatch($fileName);
        }

        // Flash success message
        session()->flash('success', 'The file has been queue for processing'); 

    }

    public function render()
    {
        return view('livewire.moneris.upload-por-customer-cards-file', [
            'customer_cards_file' =>
                Upload::where('collection', 'moneris_por_customer_cards')->first()
        ]);
    }
}
