<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\ExampleWork;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuNavController;
use App\Http\Controllers\WorkersController;
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

Route::group(['namespace' => 'App\Http\Controllers'], function(){

    // сделать доступным и для обычных авториз. пользователей
    Route::get('/works', 'ExampleWork@index')->name('work.index');
    // Route::get('/works/search?q={q}', 'ExampleWork@search')->name('work.search');

    // ajax requests
    Route::get('/ajax/changeTheme', 'HelperController@changeTheme');

    Route::middleware(['user'])->group( function() {
        // works
        Route::post('/works', 'ExampleWork@store')->name('work.store');
        Route::get('/works/{work}/edit/', 'ExampleWork@edit')->name('work.edit');
        Route::post('/works/{work}/update/', 'ExampleWork@update')->name('work.update');
        Route::get('/works/{work}/delete/', 'ExampleWork@delete')->name('work.delete');
        Route::get('/works/deleteAll/', 'ExampleWork@deleteAll');

        // workers
        Route::get('/workers', 'WorkersController@index')->name('workers.index');
        Route::post('/workers', 'WorkersController@store')->name('workers.store');
    });    

    Route::group(['middleware' => 'admin'], function() {
        Route::get('/admin/', 'AdminController@index')->name('admin.index');
        Route::get('/admin/works/', 'AdminController@examplesWork')->name('admin.works');
        Route::get('/admin/menu/', 'AdminController@menu')->name('admin.menu');
    
        Route::post('/admin/menu/', 'MenuNavController@store')->name('menu.store');
        Route::get('/admin/menu/{menuNav}/edit/', 'MenuNavController@edit')->name('menu.edit');
        Route::post('/admin/menu/{menuNav}/update', 'MenuNavController@update')->name('menu.update');
        Route::get('/admin/menu/{menuNav}/delete/', 'MenuNavController@delete')->name('menu.delete');
    });
});




// about me -  мой путь в разработке
// hobby - чем увлекаюсь

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
