<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('v1')->prefix('v1')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::middleware('auth:api')->group(function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('me', 'AuthController@me');
        //Admin
        Route::ApiResource('users', 'UserController');
        Route::ApiResource('categories', 'CategoryController');
        Route::get('categories/{id}/users', 'CategoryController@get_users');
        Route::post('categories/{id}/users', 'CategoryController@add_users');
        Route::ApiResource('schedules', 'ScheduleController');
        Route::ApiResource('disable/dates', 'DisableDateController');
        
        Route::get('appointments', 'AppointmentController@index');
        Route::get('my/appointments', 'AppointmentController@my');
        Route::get('appointments/{id}', 'AppointmentController@show');
        Route::put('appointments/{id}', 'AppointmentController@update');
        Route::delete('participants/{id}', 'AppointmentController@participants_destroy');
        Route::post('append/participants/{id}', 'AppointmentController@participants_append');
        
        Route::get('app/settings', 'SettingController@app');
        Route::post('app/settings', 'SettingController@appupdate');
        Route::get('mail/settings', 'SettingController@mail');
        Route::post('mail/settings', 'SettingController@mailupdate');
        Route::post('test/mail/settings', 'SettingController@mail_test');

        Route::post('disable/allowed-dates', 'DisableDateController@disabledallowupdate');
        Route::get('disable/allowed-dates', 'DisableDateController@disabledallow');
    });

    Route::prefix('all')->group(function () {
        Route::get('categories', 'CategoryController@all');
        Route::get('schedules', 'ScheduleController@all');
        Route::get('disable/dates', 'DisableDateController@all');
        Route::get('disable/allowed-dates', 'DisableDateController@disabledallow');
    });

    Route::get('countries', 'ScheduleController@countries');
    Route::get('setapp', 'SettingController@setapp');
    Route::get('calendar', 'ScheduleController@calendar');
    Route::post('appointments', 'AppointmentController@store');
    Route::post('validate/participants', 'AppointmentController@participants');
    Route::post('rating', 'AppointmentController@rating');
});
