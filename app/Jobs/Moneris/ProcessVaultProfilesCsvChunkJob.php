<?php

namespace App\Jobs\Moneris;

use App\Models\Moneris\MonerisToken;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessVaultProfilesCsvChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // TODO - Validate the data in the csv file before persisting it to the database

        $file = Storage::disk(config('app.uploads.disk'))->get($this->fileName);

        $records = preg_split("/((\r?\n)|(\r\n?))/", $file);

        foreach ($records as $record) {

            if (trim($record) !== null) {

                $data = str_getcsv($record);
        
                $token = MonerisToken::firstOrNew([
                    'data_key' => $data[0]
                ]);
        
                if (! $token->exists) {
                    
                    $token->created_at = $data[1];
                    $token->cust_id = $data[2];
                    $token->email = $data[3];
                    $token->phone = $data[4];
                    $token->note = $data[5];
                    $token->masked_pan = $data[6];
        
                    $token->save();
        
                }

            }

        }

        $delete = Storage::disk(config('app.uploads.disk'))->delete($this->fileName);
    
    }

}
