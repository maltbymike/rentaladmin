<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeclockController extends Controller
{
    public function show()
    {
        return view('timeclock.show');
    }

}
