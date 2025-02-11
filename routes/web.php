<?php

use App\Models\Optimizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/', function(){ return view('home'); })->name('home');


Route::group(['namespace' => 'App\Http\Controllers'], function(){

    Route::get('/search', 'SearchController@index')->name('search');

    Route::get('/works', 'Works\ItemsController@index')->name('work.index');
    Route::get('/works/{work}/detail/', 'Works\ItemsController@detail')->name('work.detail');

    Route::middleware(['auth'])->group( function() {

        Route::post('/works', 'Works\ItemsController@store')->name('work.store');

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

                Route::post('/change_user_info', 'IndexController@changeUserInfo')->name('change_user_info');
                Route::post('/change_avatar', 'IndexController@changeAvatar')->name('change_avatar');
                Route::post('/delete', 'IndexController@delete')->name('delete');

                Route::group(['controller' => 'WorksController', 'prefix' => 'works'], function() {
                    Route::name('works.')->group(function(){
                        Route::get('/', 'index')->name('index');
                        Route::get('/{work}', 'edit')->name('edit');
                        Route::post('/{work}', 'update')->name('update');
                        Route::delete('/{work}', 'delete')->name('delete');
                    });
                });
            });
        });

        Route::group(['prefix' => 'works'], function(){
            Route::get('/{work}/edit/', 'Works\ItemsController@edit')->name('works.edit');
            Route::post('/{work}/update/', 'Works\ItemsController@update')->name('works.update');
            Route::get('/{work}/delete/', 'Works\ItemsController@delete')->name('works.delete'); //todo
        });

        Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
            Route::name('admin.')->group(function(){
                Route::get('/', 'HelperController@index')->name('index');
                Route::get('/works/', 'Works\ItemsController@index')->name('works.index');
                Route::get('/users/', 'UsersController@index')->name('users.index');
                Route::get('/workers/', 'WorkersController@index')->name('workers.index');
                Route::get('/menu/', 'MenuNavController@index')->name('menu.index');
                Route::get('/feedback/', 'FeedbackController@index')->name('feedback.index');
                Route::get('/category/', 'CategoryController@index')->name('categories.index');

                Route::group(['prefix' => 'menu', 'controller' => 'MenuNavController'], function() {
                    Route::name('menu.')->group(function(){
                        Route::post('/', 'store')->name('store');
                        Route::get('/add/', 'create')->name('create');
                        Route::get('/{menuNav}/edit/', 'edit')->name('edit');
                        Route::post('/{menuNav}/update', 'update')->name('update');
                        Route::post('/{menuNav}/delete/', 'delete')->name('delete');
                    });
                });

                Route::group(['prefix' => 'works', 'controller' => 'Works\ItemsController'], function() {
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

                Route::group(['prefix' => 'category', 'controller' => 'CategoryController'], function() {
                    Route::name('categories.')->group(function () {

                        Route::get('/add/', 'create')->name('create');
                        Route::get('/entity', 'getByEntity')->name('getByEntity');
                        Route::post('/', 'store')->name('store');
                        Route::post('/{category}/delete/', 'delete')->name('delete');

                    });
                });

                Route::get('/settings', 'SettingController@index')->name('settings.index');
                Route::get('/settings/cache/clear-all', 'SettingController@cacheClearAll')->name('settings.cache.clearAll');
            });
        });

        Route::post('/ajax/translate_to_code', 'HelperController@translateToCode');
    });

    // donation

    // ajax requests
    Route::get('/ajax/change_theme', 'HelperController@changeTheme');
    Route::get('/ajax/set_lang?lang={lang}', '\App\Services\LangService@setLang' )->name('lang.setLang');
    Route::post('/ajax/feedback', 'FeedbackController@store' )->name('feedback.store');

});


Auth::routes();

Route::get('/api/google_auth.php', [ App\Services\AuthService::class, 'googleAuth' ])->name('google_auth');
Route::get('/api/yandex_auth.php', [ App\Services\AuthService::class, 'yandexAuth' ])->name('yandex_auth');

Route::get('/profile/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::post('/profile/verify/resend', [ App\Http\Controllers\Auth\VerificationController::class , 'resend' ])->middleware('auth')->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
