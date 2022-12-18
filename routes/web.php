<?php

use App\Http\Controllers\MonerisController;
use App\Http\Controllers\TimeclockController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Moneris\ProcessVaultProfilesFileController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/moneris/expiring', [MonerisController::class, 'showExpiring'])->name('moneris.showExpiring');
    Route::post('/moneris/process-vault-profiles', ProcessVaultProfilesFileController::class)->name('moneris.processVaultProfiles');
    Route::get('/moneris/upload-vault-profiles', [MonerisController::class, 'showUploadVaultProfiles'])->name('moneris.showUploadVaultProfiles');

    Route::get('/timeclock', [TimeclockController::class, 'show'])->name('timeclock');

    Route::post('/upload', UploadController::class)->name('upload');
});
