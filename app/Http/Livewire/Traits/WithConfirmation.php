<?php

    namespace App\Http\Livewire\Traits;

    trait WithConfirmation
    {
        // from https://forum.laravel-livewire.com/t/delete-confirmation-dialog-box/78/3
     
        public $confirmations = [];

        public function getListeners() 
        {
            return $this->listeners + [
                'sendConfirmation' => 'receiveConfirmation',
            ];
        }

        public function receiveConfirmation($message, $callback, $callbackData = null)
        {
            $confirmation = [
                'show' => true,
                'message' => $message,
                'callback' => $callback,
                'callbackData' => $callbackData,
            ];

            array_push($this->confirmations, $confirmation);
        }

        public function confirm($key)
        {

            $this->emit($this->confirmations[$key]['callback'], $this->confirmations[$key]['callbackData']);

            $this->removeConfirmation($key);

        }

        public function removeConfirmation($key)
        {

            $this->emit('confirmationCancelled', $this->confirmations[$key]['callback']);

            unset($this->confirmations[$key]);

        }
        
    }

?>