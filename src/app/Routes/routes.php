<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix'=>'reservations'], function(){
    // Rutas para Mi Cuenta
    Route::get('list/{token}', 'ProcessController@getPackages');
    Route::get('item/{token}', 'ProcessController@getPackage');
    Route::get('schedule-list/{accommodation_id}', 'ProcessController@getScheduleList');
    Route::get('schedule-group/{accommodation_id}', 'ProcessController@getScheduleBlock');
    Route::get('finish-reservation/{token}', 'ProcessController@getScheduleBlock');

});