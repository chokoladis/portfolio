<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleWork;
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

Route::get('/', function () {
    return view('home');
});

Route::get('/works', 'App\Http\Controllers\ExampleWork@index')->name('work.index');
Route::get('/works/create/', 'App\Http\Controllers\ExampleWork@create')->name('work.create');
Route::post('/works', 'App\Http\Controllers\ExampleWork@store')->name('work.store');
Route::get('/works/update/', 'App\Http\Controllers\ExampleWork@update');
Route::get('/works/delete/', 'App\Http\Controllers\ExampleWork@delete');
Route::get('/works/deleteAll/', 'App\Http\Controllers\ExampleWork@deleteAll');

// about me -  мой путь в разработке
// hobby - чем увлекаюсь