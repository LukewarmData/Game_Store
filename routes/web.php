<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/BznsSoka', function () {
    return view('welcome');
});
