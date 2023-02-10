<?php

use App\Http\Controllers\MonerisController;
use App\Http\Controllers\Moneris\ProcessVaultProfilesFileController;
use App\Http\Controllers\User\UserPermissionController;
use App\Http\Controllers\User\UserController;
use App\Http\Livewire\Products\Categories\GetProductCategoriesFromApi;
use App\Http\Livewire\Timeclock\ShowTimeclockClockInOut;
use App\Http\Livewire\Timeclock\ShowTimeclockUsers;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {


    Route::get('/', function () { return view('dashboard'); })
        ->name('dashboard');


    // Moneris Token Routes
    Route::middleware('can:view moneris vault tokens')->group(function () {    
        
        Route::get('/moneris/expiring', [MonerisController::class, 'showExpiring'])
            ->name('moneris.showExpiring');
        
        Route::get('/moneris/point-of-rental-payment-tokens', [MonerisController::class, 'showPointOfRentalPaymentTokens'])
            ->name('moneris.showPointOfRentalPaymentTokens');
        
        Route::get('/moneris/vault-profiles', [MonerisController::class, 'showVaultProfiles'])
            ->name('moneris.showVaultProfiles');
    
    });

    // Products Routes
    Route::get('/products/categories/get', GetProductCategoriesFromApi::class)
        ->name('product.categories.get');


    // Timeclock Routes
    Route::get('/timeclock/{user}/clock-in-out', ShowTimeclockClockInOut::class)
        ->name('timeclock');
    Route::get('/timeclock/users', ShowTimeclockUsers::class)
        ->name('timeclock.users');

    // User Management Routes
    Route::get('/user/profile/create', [UserController::class, 'create'])
        ->name('profile.create');
    Route::get('/user/profile/{user}/permissions', [UserPermissionController::class, 'show'])
        ->name('profile.permissions.show');

});
