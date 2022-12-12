<?php

namespace App\Http\Livewire\Moneris;

use App\Libraries\Moneris\mpgTransaction;
use App\Libraries\Moneris\mpgRequest;
use App\Libraries\Moneris\mpgHttpsPost;

use Livewire\Component;

class GetExpiring extends Component
{
    public $expiring = [];

    public $response = [];

    public $isTestMode = true;

    public function getExpiring()
    {
        $isTestMode = $this->isTestMode;

        $apiCredentials = $this->getApiCredentials();

        $storeId = $apiCredentials['storeId'];
        $apiToken = $apiCredentials['apiToken'];
        
        $type = 'res_get_expiring';

        $txnArray = array ( 'type' => $type );

        $mpgTxn = new mpgTransaction($txnArray);

        $mpgRequest = new mpgRequest($mpgTxn);
        $mpgRequest->setTestMode($isTestMode);

        $mpgHttpPost = new mpgHttpsPost($storeId, $apiToken, $mpgRequest);

        $mpgResponse = $mpgHttpPost->getMpgResponse();

        $this->response['code'] = $mpgResponse->getResponseCode();
        $this->response['message'] = $mpgResponse->getMessage();
        $this->response['trans_date'] = $mpgResponse->getTransDate();
        $this->response['trans_time'] = $mpgResponse->getTransTime();
        $this->response['complete'] = $mpgResponse->getComplete();
        $this->response['timed_out'] = $mpgResponse->getTimedOut();
        $this->response['success'] = $mpgResponse->getResSuccess();
        $this->response['payment_type'] = $mpgResponse->getPaymentType();
        
        $this->expiring = $mpgResponse->resolveDataHash;

    }

    protected function getApiCredentials()
    {

        if ($this->isTestMode == false) {

            return [
                'storeId' => env('MONERIS_STORE_ID'),
                'apiToken' => env('MONERIS_API_TOKEN'),
            ];

        } else {

            return [
                'storeId' => 'store5',
                'apiToken' => 'yesguy',
            ];    

        }

    }

    public function render()
    {
        return view('livewire.moneris.get-expiring');
    }
}
