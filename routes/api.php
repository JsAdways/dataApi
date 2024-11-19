<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Jsadways\DataApi\Controllers\DataController;

//Route::middleware(['js-authenticate-middleware-alias'])->group(function () {
    Route::group(['prefix' => 'api/data_api'], function () {
        Route::post('/fetch', [DataController::class, 'fetch']);
        Route::get('/get', [DataController::class, 'get']);
    });
//});
