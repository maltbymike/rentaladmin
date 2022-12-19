<?php

namespace App\Jobs\Moneris;

use App\Libraries\Moneris\mpgTransaction;
use App\Libraries\Moneris\mpgRequest;
use App\Libraries\Moneris\mpgHttpsPost;

use App\Models\Moneris\MonerisToken;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTokensFromVaultInChunks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tokens;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tokens)
    {
        $this->tokens = $tokens;  
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach ($this->tokens as $token) {

            // Set Moneris Connection Variables
            $store_id = env('MONERIS_STORE_ID');
            $api_token = env('MONERIS_API_TOKEN');
            $test_mode = env('MONERIS_TEST_MODE');
            $type = 'res_lookup_masked';        

            // Transactional Variables
            $data_key = $token->data_key;

            // Transactional Associative Array
            $txnArray = array('type' => $type, 'data_key' => $data_key);

            // Transaction Object
            $mpgTxn = new mpgTransaction($txnArray);

            // Request Object
            $mpgRequest = new mpgRequest($mpgTxn);
            $mpgRequest->setTestMode($test_mode);

            // HTTPS Post Object
            $mpgHttpsPost = new mpgHttpsPost($store_id, $api_token, $mpgRequest);

            // Response
            $mpgResponse = $mpgHttpsPost->getMpgResponse();

            // Update Model
            $token->exp_date = $mpgResponse->getResDataExpDate();
            $token->crypt_type = $mpgResponse->getResDataCryptType();
            $token->avs_street_number = $mpgResponse->getResDataAvsStreetNumber();
            $token->avs_street_name = $mpgResponse->getResDataAvsStreetName();
            $token->avs_zipcode = $mpgResponse->getResDataAvsZipcode();

            $token->save();

        }

    }

}
