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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/after_login', function () {
    return view('after_login');
})->middleware(['auth'])->name('after_login');

Route::get('/home_page', function () {
    return view('home_page2');
})->middleware(['auth'])->name('home_page');

Route::get('/home_page1', function () {
    return view('home_page');
})->middleware(['auth'])->name('home_page1');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/system_user_main2', function () {
    return view('system_user_main2');
})->middleware(['auth'])->name('system_user_main2');

require __DIR__.'/auth.php';
