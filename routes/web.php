<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function(){ return view('home'); })->name('home');
Route::get('/about', function(){ return view('about'); })->name('about');

Route::group(['namespace' => 'App\Http\Controllers'], function(){

    Route::get('/search', 'SearchController@index')->name('search');

    Route::get('/works', 'ExampleWorkController@index')->name('work.index');
    Route::get('/works/{work}/detail/', 'ExampleWorkController@detail')->name('work.detail');

    Route::middleware(['auth'])->group( function() {
        
        Route::post('/works', 'ExampleWorkController@store')->name('work.store');

        Route::group(['prefix' => 'workers', 'controller' => 'WorkersController'], function(){
            Route::name('workers.')->group(function(){
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{worker}/', 'detail')->name('detail');
                Route::get('/{worker}/works/', 'works')->name('works');
            });
        });

        Route::group(['namespace' => 'Profile', 'prefix' => 'profile'], function() {
            Route::name('profile.')->group(function(){
                    
                Route::get('/', 'IndexController@index')->name('index');
                Route::post('/', 'IndexController@update')->name('update');

                Route::post('/change_avatar', 'IndexController@changeAvatar')->name('change_avatar');
                Route::post('/delete', 'IndexController@delete')->name('delete');

                Route::group(['controller' => 'WorksController', 'prefix' => 'works'], function() {
                    Route::name('works.')->group(function(){
                        Route::get('/', 'index')->name('index');
                        Route::get('/{work}', 'edit')->name('edit');
                        Route::post('/{work}', 'update')->name('update');
                        Route::post('/{work}/delete', 'delete')->name('delete');
                    });
                });
            });
        });
        
        Route::group(['prefix' => 'works'], function(){
        // Route::middleware(['isBelongsToUser:Example_work::class'])->group( function() {
            Route::get('/{work}/edit/', 'ExampleWorkController@edit')->name('works.edit');
            Route::post('/{work}/update/', 'ExampleWorkController@update')->name('works.update');
            Route::get('/{work}/delete/', 'ExampleWorkController@delete')->name('works.delete'); //todo
        // });
        });

        Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
            Route::name('admin.')->group(function(){
                Route::get('/', 'HelperController@index')->name('index');
                Route::get('/works/', 'ExampleWorkController@index')->name('works.index');
                Route::get('/workers/', 'WorkersController@index')->name('workers.index');
                Route::get('/menu/', 'MenuNavController@index')->name('menu.index');
                Route::get('/feedback/', 'FeedbackController@index')->name('feedback.index');

                Route::group(['prefix' => 'menu', 'controller' => 'MenuNavController'], function() {
                    Route::name('menu.')->group(function(){
                        Route::post('/', 'store')->name('store');
                        Route::get('/add/', 'create')->name('create');
                        Route::get('/{menuNav}/edit/', 'edit')->name('edit');
                        Route::post('/{menuNav}/update', 'update')->name('update');
                        Route::get('/{menuNav}/delete/', 'delete')->name('delete');
                    });
                });
                
                Route::group(['prefix' => 'works', 'controller' => 'ExampleWorkController'], function() {
                    Route::name('works.')->group(function(){                        
                        Route::get('/{work}/edit/', 'edit')->name('edit');
                        Route::post('/{work}/update', 'update')->name('update');
                        Route::get('/{work}/delete/', 'delete')->name('delete');
                        Route::get('/{work}/forceDelete/', 'forceDelete')->name('forceDelete');
                        Route::get('/{work}/restore/', 'restore')->name('restore');

                        Route::get('/recycle/', 'recycle')->name('recycle');
                        Route::post('/recycle/delete', 'recycleDelete')->name('recycleDelete');
                        Route::post('/recycle/restore', 'recycleRestore')->name('recycleRestore');
                    });
                });
                
                Route::group(['prefix' => 'workers', 'controller' => 'WorkersController'], function() {
                    Route::name('workers.')->group(function(){                        
                        Route::get('/{worker}/edit/', 'edit')->name('edit');
                        Route::post('/{worker}/update', 'update')->name('update');
                        Route::get('/{worker}/delete/', 'delete')->name('delete');
                        Route::get('/{worker}/forceDelete/', 'forceDelete')->name('forceDelete');
                        // Route::get('/{worker}/restore/', 'restore')->name('restore');
                    });
                });
    
                Route::group(['prefix' => 'feedback'], function() {
                    Route::get('/{feedback}/show/', 'FeedbackController@show')->name('feedback.show');
                    Route::get('/{feedback}/delete/', 'FeedbackController@delete')->name('feedback.delete');
                });
            });
        });
    });

    // ajax requests
    Route::get('/ajax/changeTheme', 'HelperController@changeTheme');
    Route::post('/ajax/feedback', 'FeedbackController@store' )->name('feedback.store');
});



// about me -  мой путь в разработке
// hobby - чем увлекаюсь

Auth::routes();
