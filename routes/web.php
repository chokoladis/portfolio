<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
=======
use Illuminate\Foundation\Auth\EmailVerificationRequest;
>>>>>>> Stashed changes


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
            Route::get('/{work}/edit/', 'ExampleWorkController@edit')->name('works.edit');
            Route::post('/{work}/update/', 'ExampleWorkController@update')->name('works.update');
            Route::get('/{work}/delete/', 'ExampleWorkController@delete')->name('works.delete'); //todo
        });

        Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
            Route::name('admin.')->group(function(){
                Route::get('/', 'HelperController@index')->name('index');
                Route::get('/works/', 'ExampleWorkController@index')->name('works.index');
                Route::get('/users/', 'UsersController@index')->name('users.index');
                Route::get('/workers/', 'WorkersController@index')->name('workers.index');
                Route::get('/menu/', 'MenuNavController@index')->name('menu.index');
                Route::get('/feedback/', 'FeedbackController@index')->name('feedback.index');

                Route::group(['prefix' => 'menu', 'controller' => 'MenuNavController'], function() {
                    Route::name('menu.')->group(function(){
                        Route::post('/', 'store')->name('store');
                        Route::get('/add/', 'create')->name('create');
                        Route::get('/{menuNav}/edit/', 'edit')->name('edit');
                        Route::post('/{menuNav}/update', 'update')->name('update');
                        Route::post('/{menuNav}/delete/', 'delete')->name('delete');
                    });
                });
                
                Route::group(['prefix' => 'works', 'controller' => 'ExampleWorkController'], function() {
                    Route::name('works.')->group(function(){                        
                        Route::get('/{work}/edit/', 'edit')->name('edit');
                        Route::post('/{work}/update', 'update')->name('update');
                        Route::post('/{work}/delete/', 'delete')->name('delete');
                        Route::post('/{work}/forceDelete/', 'forceDelete')->name('forceDelete');
                        Route::get('/{work}/restore/', 'restore')->name('restore');

                        Route::get('/recycle/', 'recycle')->name('recycle');
                        Route::post('/recycle/delete', 'recycleDelete')->name('recycleDelete');
                        Route::post('/recycle/restore', 'recycleRestore')->name('recycleRestore');
                    });
                });
                
                Route::group(['prefix' => 'users', 'controller' => 'UsersController'], function() {
                    Route::name('users.')->group(function(){                        
                        Route::get('/{user}/edit/', 'edit')->name('edit');
                        Route::post('/{user}/update', 'update')->name('update');
                        Route::post('/{user}/delete/', 'delete')->name('delete');
                        // Route::get('/{worker}/forceDelete/', 'forceDelete')->name('forceDelete');
                        // Route::get('/{worker}/restore/', 'restore')->name('restore');
                    });
                });
                
                Route::group(['prefix' => 'workers', 'controller' => 'WorkersController'], function() {
                    Route::name('workers.')->group(function(){
                        Route::get('/{worker}/edit/', 'edit')->name('edit');
                        Route::post('/{worker}/update', 'update')->name('update');
                        Route::post('/{worker}/delete/', 'delete')->name('delete');
                        Route::post('/{worker}/forceDelete/', 'forceDelete')->name('forceDelete');
                        // Route::get('/{worker}/restore/', 'restore')->name('restore');
                    });
                });
    
                Route::group(['prefix' => 'feedback', 'controller' => 'FeedbackController'], function() {
                    Route::name('feedback.')->group(function(){
                        Route::get('/{feedback}/show/', 'show')->name('show');
                        Route::get('/{feedback}/delete/', 'delete')->name('delete');

                        Route::get('/recycle/', 'recycle')->name('recycle');
                        Route::post('/recycle/delete', 'recycleDelete')->name('recycleDelete');
                        Route::post('/recycle/restore', 'recycleRestore')->name('recycleRestore');
                    });
                });
            });
        });
    });

    // ajax requests
    Route::get('/ajax/changeTheme', 'HelperController@changeTheme');
    Route::post('/ajax/feedback', 'FeedbackController@store' )->name('feedback.store');
});


<<<<<<< Updated upstream

// about me -  мой путь в разработке
// hobby - чем увлекаюсь

Auth::routes();
=======
Auth::routes();

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
>>>>>>> Stashed changes
