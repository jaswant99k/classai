<?php

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

Route::group(['middleware' => ['subdomain']], function () {
    Route::prefix('razorpay')->group(function () {
        Route::get('/', 'RazorPayController@index');
        Route::get('about', 'RazorPayController@about');
        Route::get('pay', 'RazorPayController@pay')->name('pay');
        Route::post('dopayment', 'RazorPayController@dopayment')->name('razorpay/dopayment');

        Route::post('get-order-id', 'RazorPayController@getOrderId')->name('razorpay.get-order-id');
    });
});