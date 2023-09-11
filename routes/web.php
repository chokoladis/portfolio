<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleWork;
use App\Http\Controllers\Admin\AdminController;
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
// ajax area
Route::get('/works?ajax=worksList', 'App\Http\Controllers\ExampleWork@worksList');
// Route::get('/works?ajax=workShow&id={work}', 'App\Http\Controllers\ExampleWork@edit')->name('work.edit');

// Route::get('/works/create/', 'App\Http\Controllers\ExampleWork@create')->name('work.create');
Route::post('/works', 'App\Http\Controllers\ExampleWork@store')->name('work.store');
// Route::get('/works/{work}', 'App\Http\Controllers\ExampleWork@detail')->name('work.detail.index');
Route::get('/works/{work}/edit/', 'App\Http\Controllers\ExampleWork@edit')->name('work.edit');
Route::post('/works/{work}/update/', 'App\Http\Controllers\ExampleWork@update')->name('work.update');
Route::get('/works/{work}/delete/', 'App\Http\Controllers\ExampleWork@delete')->name('work.delete');
Route::get('/works/deleteAll/', 'App\Http\Controllers\ExampleWork@deleteAll');

Route::group(['namespace' => 'App\\Http\\Controllers\\Admin', 'middleware' => 'admin'], function() {
    Route::get('/admin/', 'AdminController@index')->name('admin.index');
    Route::get('/admin/works/', 'AdminController@examplesWork')->name('admin.works');
    Route::get('/admin/menu/', 'AdminController@menu')->name('admin.menu');
});


// about me -  мой путь в разработке
// hobby - чем увлекаюсь

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
