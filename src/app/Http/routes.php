<?php

Route::get('/', function(){
    return response()->view('welcome')->header('X-CSRF-TOKEN', csrf_token());
});

Route::post('/', 'HashController@create');
Route::get('/{hash}', 'HashController@redirect');
Route::put('/{hash}', 'HashController@update');

