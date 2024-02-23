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

Route::get('/', function(){ return view('home'); })->name('home');
Route::get('/about', function(){ return view('about'); })->name('about');

Route::group(['namespace' => 'App\Http\Controllers'], function(){

    Route::get('/search', 'SearchController@index')->name('search');

    Route::get('/works', 'ExampleWorkController@index')->name('work.index');
    Route::get('/works/{work}/detail/', 'ExampleWorkController@detail')->name('work.detail');

    // ajax requests
    Route::get('/ajax/changeTheme', 'HelperController@changeTheme');
    Route::post('/ajax/feedback', 'FeedbackController@store' )->name('feedback.store');

    Route::middleware(['auth'])->group( function() {
        
        Route::post('/works', 'ExampleWorkController@store')->name('work.store');

        Route::group(['prefix' => 'workers'], function(){
            Route::get('/', 'WorkersController@index')->name('workers.index');
            Route::post('/', 'WorkersController@store')->name('workers.store');
            Route::get('/{worker}/', 'WorkersController@detail')->name('workers.detail');
            Route::get('/{worker}/works/', 'WorkersController@works')->name('workers.works');
        });

        Route::group(['namespace' => 'Profile'], function() {

            Route::get('/profile', 'IndexController@index')->name('profile.index');

            Route::get('/profile/works', 'WorksController@index')->name('profile.works.index');
            Route::get('/profile/works/{work}', 'WorksController@edit')->name('profile.works.edit');
            Route::post('/profile/works/{work}', 'WorksController@update')->name('profile.works.update');
            Route::post('/profile/works/{work}/delete', 'WorksController@delete')->name('profile.works.delete');
            // Route::get('/profile/works/{work}/files', 'WorksController@filesAdd')->name('profile.works.files.add');
            // Route::post('/profile/works/{work}/files', 'WorksController@filesStore')->name('profile.works.files.store');
            

            Route::post('/profile', 'IndexController@update')->name('profile.update');
            Route::post('/ajax/profile/change_avatar', 'IndexController@changeAvatar')->name('profile.change_avatar');
            Route::post('/profile/delete', 'IndexController@delete')->name('profile.delete');

        });
        
        Route::group(['prefix' => 'works'], function(){
        // Route::middleware(['isBelongsToUser:Example_work::class'])->group( function() {
            Route::get('/{work}/edit/', 'ExampleWorkController@edit')->name('works.edit');
            Route::post('/{work}/update/', 'ExampleWorkController@update')->name('works.update');
            Route::get('/{work}/delete/', 'ExampleWorkController@delete')->name('works.delete'); //todo
        // });
        });

        Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
            Route::get('/', 'HelperController@index')->name('admin.index');
            Route::get('/works/', 'ExampleWorkController@index')->name('admin.works.index');
            Route::get('/workers/', 'WorkersController@index')->name('admin.workers.index');
            Route::get('/menu/', 'MenuNavController@index')->name('admin.menu.index');
            Route::get('/feedback/', 'FeedbackController@index')->name('admin.feedback.index');
        
            Route::group(['prefix' => 'menu'], function() {
                Route::post('/', 'MenuNavController@store')->name('admin.menu.store');
                Route::get('/add/', 'MenuNavController@create')->name('admin.menu.create');
                Route::get('/{menuNav}/edit/', 'MenuNavController@edit')->name('admin.menu.edit');
                Route::post('/{menuNav}/update', 'MenuNavController@update')->name('admin.menu.update');
                Route::get('/{menuNav}/delete/', 'MenuNavController@delete')->name('admin.menu.delete');
            });

            Route::group(['prefix' => 'feedback'], function() {
                Route::get('/{feedback}/show/', 'FeedbackController@show')->name('admin.feedback.show');
                Route::get('/{feedback}/delete/', 'FeedbackController@delete')->name('admin.feedback.delete');

            });
        });
    });
});



// about me -  мой путь в разработке
// hobby - чем увлекаюсь

Auth::routes();
