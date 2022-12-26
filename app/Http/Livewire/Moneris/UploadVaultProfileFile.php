<?php

namespace App\Http\Livewire\Moneris;

use App\Http\Livewire\Tools\UploadFile;

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

    public function render()
    {
        return view('livewire.moneris.upload-vault-profile-file');
    }
}
