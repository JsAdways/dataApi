<?php

use Illuminate\Support\Facades\Route;
use Jsadways\DataApi\Controllers\DataController;

Route::group(['prefix' => 'api/data_api'], function () {
    Route::post('/fetch', [DataController::class, 'fetch']);
    Route::get('/get', [DataController::class, 'get']);
    //for service api
    Route::post('/service', [DataController::class, 'service']);
});
