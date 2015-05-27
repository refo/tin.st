<?php

Route::get('/', function(){
    return redirect('http://tinkongroup.com/');
});

Route::post('/', 'SlugController@create');
Route::get('/{hash}', 'SlugController@redirect');
