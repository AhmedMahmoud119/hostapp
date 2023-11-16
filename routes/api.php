<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GenerateJobController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['userHeader','currency']], function () {

    Route::get('/generate', [GenerateJobController::class, 'generateJob']);
    Route::get('/get-job', [GenerateJobController::class, 'getJob']);

});

Route::group(['middleware' => ['userHeaderEvent','currency']], function () {
    Route::post('/event', [EventController::class, 'event']);
});

Route::post('/save-products', [ProductController::class, 'saveProducts']);


//      https://h-v1.4jawaly.com/index.php?bash#
//      https://api2.hostbillapp.com/invoices/getInvoiceDetails.html
