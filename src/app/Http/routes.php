<?php

Route::get('/', function(){
    return response()->view('welcome')->header('X-CSRF-TOKEN', csrf_token());
});

Route::post('/', 'SlugController@create');
Route::get('/{hash}', 'SlugController@redirect');
Route::put('/{hash}', 'SlugController@update');

