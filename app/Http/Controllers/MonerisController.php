<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonerisController extends Controller
{
    public function showExpiring()
    {
        return view('moneris.show_expiring');
    }
}
