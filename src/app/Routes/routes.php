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
Route::get('test/preview-reservation', 'TestController@getPreivewReservation');
Route::get('test/preview-ticket', 'TestController@getPreivewTicket');

Route::get('reservations', 'ProcessController@getPackages');

Route::get('reservaciones/{step?}/{accommodation?}/{provider_id?}', array('as' => 'ProcessController', 'uses' => 'ProcessController@findReservas'));
Route::get('seleccionar-horarios/{reservation_id}/{date?}', array('as' => 'ProcessController', 'uses' => 'ProcessController@findSelectSchedule'));
Route::get('finalizar-reserva/{reservation_id}', array('as' => 'ProcessController', 'uses' => 'ProcessController@findReserva'));

Route::group(['prefix'=>'reservations'], function(){
    Route::get('my-reservations/{token}', 'ProcessController@getMyReservations');
    Route::get('reservation/{reservation_id}', 'ProcessController@getReservation');
    Route::get('list/{token}', 'ProcessController@getPackages');
    Route::get('item/{token}', 'ProcessController@getPackage');
    Route::post('start-reservation', 'ProcessController@postStartReservation');
    Route::get('schedule-list/{accommodation_id}/{reservation_id}', 'ProcessController@getScheduleList');
    Route::get('schedule-group/{accommodation_id}/{reservation_id}', 'ProcessController@getScheduleBlock');
    Route::get('pick-schedule-reservation/{accommodation_id}/{reservation_id}/{initial_date}/{end_date}/{initial_time}/{end_time}', 'ProcessController@getPickScheduleReservation');
    Route::get('cancel-reservation/{reservation_id}', 'ProcessController@getCancelReservation');
    Route::get('finish-reservation/{accommodation_id}/{reservation_id}', 'ProcessController@getFinishReservation');
    Route::post('finish-reservation', 'ProcessController@postFinishReservation');
});
