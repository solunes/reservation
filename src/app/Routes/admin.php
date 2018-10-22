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

Route::group(['prefix'=>'admin'], function(){
    
    // Módulo de Reservas
    Route::get('accommodations', 'CustomAdminController@getAccommodations');
    Route::get('accommodation/{id}', 'CustomAdminController@findAccommodation');

    // Módulo de Reportes
    //Route::get('reservation-report', 'ReportController@getReservationReport');

});