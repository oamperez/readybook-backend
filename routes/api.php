<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('v1')->prefix('v1')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::middleware('auth:api')->group(function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('me', 'AuthController@me');
        //Admin
        Route::ApiResource('categories', 'CategoryController');
        Route::ApiResource('schedules', 'ScheduleController');
        Route::get('appointments', 'AppointmentController@index');
    });

    Route::prefix('all')->group(function () {
        Route::get('categories', 'CategoryController@all');
        Route::get('schedules', 'ScheduleController@all');
    });

    Route::post('appointments', 'AppointmentController@store');
});