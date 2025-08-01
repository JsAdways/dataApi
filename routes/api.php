<?php

use Illuminate\Support\Facades\Route;
use Jsadways\DataApi\Controllers\DataController;
use Jsadways\DataApi\Controllers\CommandController;

Route::group(['prefix' => 'api/data_api'], function () {

    //for data api
    Route::post('/fetch', [DataController::class, 'fetch']);

    //for process api
    Route::post('/process', [DataController::class, 'process']);

    //for notification api
    Route::post('/notification', [DataController::class, 'notification']);

    Route::get('/get', [DataController::class, 'get']);
    //for command api
    Route::post('/command/service_list', [CommandController::class, 'service_list']);
});
