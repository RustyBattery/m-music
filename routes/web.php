<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/image', function () {
    return view('image');
});

Route::get('/image/1', function () {
    return view('image1');
});

Route::get('/image/2', function () {
    return view('image2');
});

Route::get('/image/3', function () {
    return view('image3');
});

Route::get('/image/4', function () {
    return view('image4');
});

Route::get('/video', function () {
    return view('video');
});
