<?php

namespace App\Http\Controllers;

use App\Models\Upload;

use Illuminate\Http\Request;

class MonerisController extends Controller
{
    public function showExpiring()
    {
        return view('moneris.show_expiring');
    }

    public function showVaultProfiles()
    {
        return view('moneris.show_vault_profiles');
    }

    public function showUploadVaultProfiles()
    {
        $existingFiles = Upload::where('collection', 'moneris_vault_profiles')->get();

        return view('moneris.show_upload_vault_profiles')
            ->with('existingFiles', $existingFiles);
    }
}
