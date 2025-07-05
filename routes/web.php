<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/laravel-websockets', function () {
    $apps = config('websockets.apps');
    return view('vendor.laravel-websockets.dashboard', [
        'apps' => $apps,
        'port' => config('websockets.dashboard.port', 6001),
    ]);
});

// routes/web.php
Route::get('/my-websocket-test', function () {
    return view('my-socket-test');
});

Route::get('/', function () {
    return view('welcome');
});
