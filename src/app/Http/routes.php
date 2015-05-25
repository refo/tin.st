<?php

Route::get('/', function(){
    return response()->view('welcome');
});
