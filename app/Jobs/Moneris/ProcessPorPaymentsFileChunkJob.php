<?php

namespace App\Jobs\Moneris;

use App\Models\Moneris\MonerisPorPaymentToken;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;

class ProcessPorPaymentsFileChunkJob implements ShouldQueue
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

        // Get filename
        $file = Storage::disk(config('app.uploads.disk'))->get($this->fileName);

        // Split file into an array of lines
        $data = preg_split("/\r\n|\n|\r/", $file);

        // Shift the header row out of the array
        $header = array_shift($data);

        // create an array of header field names
        $headerFields = explode(',', $header);

        // loop through file line by line
        foreach ($data as $row) {
            
            // Remove string value 'NULL' from row
            $row = str_replace(',NULL', ',', $row);

            // Split line into array
            $rowArray = str_getcsv($row, ',');

            // If the current row doesn't have the same number of fields as the headerFields row then it is malformed so skip it
            // TODO - Log error
            if (count($rowArray) === count($headerFields)) {

                // Create an array using headerFields as array keys
                $values = array_combine($headerFields, $rowArray);
            
                // Point of Rental stores the token, web order id, and a 3rd unknown value in the EncryptedCard field
                $splitEncryptedCard = str_getcsv($values['EncryptedCard'], '|');
                
                // If there isn't 3 values then the token is not stored correctly in Point of Rental so ignore it
                if (count($splitEncryptedCard) === 3) {
                    $por_token = $splitEncryptedCard[0];
                    $order_id = $splitEncryptedCard[1];
                } else {
                    $por_token = null;
                    $order_id = null;
                }

                // See if token already exists
                $token = MonerisPorPaymentToken::firstOrNew([
                    'payment_id' => $values['Payment'],
                ]);

                // If the token is new then add the rest of the fields
                if (! $token->exists) {
                    $token->por_token = $por_token;
                    $token->order_id = $order_id;
                    $token->payment_id = $values['Payment'];
                    $token->batch = $values['Batch'];
                    $token->store = $values['Store'];
                    $token->date = $values['Date'];
                    $token->operator_id = $values['Opr'];
                    $token->drawer = $values['Drawer'];
                    $token->payment_type = $values['Type'];
                    $token->customer_id = $values['CustNumb'];
                    $token->payment_amount = $values['Amount'];
                    $token->payment_method = $values['Meth'];
                    $token->card_reference = $values['RefNo'];
                    $token->notes = $values['Notes'];
                    $token->encrypted = $values['Encrypted'];
                    $token->amount_tendered = $values['Tendered'];
                    $token->terminal = $values['Terminal'];
                    $token->accounting_link = $values['AccountingLink'];
                    $token->gl_transaction_group_id = $values['GLTransactionGroupId'];
                    $token->transaction_id = $values['TransID'];
                    $token->parent_payment_id = $values['ParentPaymentId'];
                    $token->transaction_type = $values['TransType'];
                    
                    $token->save();
                
                }
            
            }
        
        }

        // Clean up the file from storage
        $delete = Storage::disk(config('app.uploads.disk'))->delete($this->fileName);

    }
}
