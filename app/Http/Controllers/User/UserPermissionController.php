<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    /**
     * Show the user permssions screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $user)
    {
        return view('profile.permissions.show', [
            'request' => $request,
            'currentUser' => $request->user(),
            'userToModify' => $user,
        ]);
    }

}
