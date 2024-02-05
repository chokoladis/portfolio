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

Route::get('/', function(){
    return view('home');
})->name('home');

Route::group(['namespace' => 'App\Http\Controllers'], function(){

    // сделать доступным и для обычных авториз. пользователей
    Route::get('/works', 'ExampleWorkController@index')->name('work.index');
    Route::get('/works/{work}/detail/', 'ExampleWorkController@detail')->name('work.detail');
    // Route::get('/works/search?q={q}', 'ExampleWorkController@search')->name('work.search');

    // ajax requests
    Route::get('/ajax/changeTheme', 'HelperController@changeTheme');

    Route::middleware(['auth'])->group( function() {
        
        Route::post('/works', 'ExampleWorkController@store')->name('work.store');

        Route::group(['prefix' => 'workers'], function(){
            Route::get('/', 'WorkersController@index')->name('workers.index');
            Route::post('/', 'WorkersController@store')->name('workers.store');
            Route::get('/{worker}/', 'WorkersController@detail')->name('workers.detail');
            Route::get('/{worker}/works/', 'WorkersController@works')->name('workers.works');
        });

        Route::get('/profile', 'ProfileController@index')->name('profile.index');
        Route::get('/profile/works', 'ProfileController@works')->name('profile.works.index');
        Route::post('/profile', 'ProfileController@update')->name('profile.update');
        Route::post('/ajax/profile/change_avatar', 'ProfileController@changeAvatar')->name('profile.change_avatar');
        Route::post('/profile/delete', 'ProfileController@delete')->name('profile.delete');
        
        Route::group(['prefix' => 'works'], function(){
        // Route::middleware(['isBelongsToUser:Example_work::class'])->group( function() {
            Route::get('/{work}/edit/', 'ExampleWorkController@edit')->name('work.edit');
            Route::post('/{work}/update/', 'ExampleWorkController@update')->name('work.update');
            Route::get('/{work}/delete/', 'ExampleWorkController@delete')->name('work.delete'); //todo
        // });
        });

        Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
            Route::get('/', 'HelperController@index')->name('admin.index');
            Route::get('/works/', 'ExampleWorkController@index')->name('admin.works.index');
            Route::get('/workers/', 'WorkersController@index')->name('admin.workers.index');
            Route::get('/menu/', 'MenuNavController@index')->name('admin.menu.index');
        
            Route::group(['prefix' => 'menu'], function() {
                Route::post('/', 'MenuNavController@store')->name('admin.menu.store');
                Route::get('/add/', 'MenuNavController@create')->name('admin.menu.create');
                Route::get('/add/', 'MenuNavController@create')->name('admin.menu.create');
                Route::get('/{menuNav}/edit/', 'MenuNavController@edit')->name('admin.menu.edit');
                Route::post('/{menuNav}/update', 'MenuNavController@update')->name('admin.menu.update');
                Route::get('/{menuNav}/delete/', 'MenuNavController@delete')->name('admin.menu.delete');
            });
        });
    });
});



// about me -  мой путь в разработке
// hobby - чем увлекаюсь

Auth::routes();
