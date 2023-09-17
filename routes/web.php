<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleWork;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\MenuNavController;;
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
// Route::get('/works/search?q={q}', 'App\Http\Controllers\ExampleWork@search')->name('work.search');
// ajax area
Route::get('/works?ajax=worksList', 'App\Http\Controllers\ExampleWork@worksList');

Route::get('/workers', 'App\Http\Controllers\Workers@index')->name('workers.index');

Route::group(['middleware' => ['admin', 'user']], function(){
    Route::post('/works', 'App\Http\Controllers\ExampleWork@store')->name('work.store');
    Route::get('/works/{work}/edit/', 'App\Http\Controllers\ExampleWork@edit')->name('work.edit');
    Route::post('/works/{work}/update/', 'App\Http\Controllers\ExampleWork@update')->name('work.update');
    Route::get('/works/{work}/delete/', 'App\Http\Controllers\ExampleWork@delete')->name('work.delete');
    Route::get('/works/deleteAll/', 'App\Http\Controllers\ExampleWork@deleteAll');
});

Route::group(['namespace' => 'App\\Http\\Controllers\\Admin', 'middleware' => 'admin'], function() {
    Route::get('/admin/', 'AdminController@index')->name('admin.index');
    Route::get('/admin/works/', 'AdminController@examplesWork')->name('admin.works');
    Route::get('/admin/menu/', 'AdminController@menu')->name('admin.menu');
});

Route::group(['middleware' => 'admin'], function() {
    Route::post('/admin/menu/', [App\Http\Controllers\MenuNavController::class, 'store'])->name('menu.store');
    Route::get('/admin/menu/{menuNav}/edit/', [App\Http\Controllers\MenuNavController::class, 'edit'])->name('menu.edit');
    Route::post('/admin/menu/{menuNav}/update', [App\Http\Controllers\MenuNavController::class, 'update'])->name('menu.update');
    Route::get('/admin/menu/{menuNav}/delete/', [App\Http\Controllers\MenuNavController::class, 'delete'])->name('menu.delete');
});


// about me -  мой путь в разработке
// hobby - чем увлекаюсь

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
