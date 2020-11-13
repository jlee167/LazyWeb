<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
});


Route::get('/about', function () {
    return view('about');
});


Route::get('/main', function () {
    return view('main');
});

Route::get('/views/{php_view_file}', function ($php_view_file) {
    return view($php_view_file);
});