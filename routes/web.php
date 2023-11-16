<?php

use App\Http\Helper\HelperGeneral;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

});

Route::get('/clear-cache', function() {
    $exitCode = \Artisan::call('config:cache');
    $exitCode = \Artisan::call('config:clear');
     return 'done';
});

Route::get('/pro', function() {

});
