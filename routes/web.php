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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');

    Route::get('contact', function () {
        return view('contact');
    })->name('contact');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('admin/users', 'App\Http\Controllers\UsersController', ['except' => ['show']]);
    Route::resource('admin/controls', 'App\Http\Controllers\CurtainControlsController', ['except' => ['show']]);
    Route::resource('admin/types', 'App\Http\Controllers\TypesController', ['except' => ['show']]);

    Route::get('orders/type', 'App\Http\Controllers\TypesController@productType')->name('orders.type');
    Route::post('orders/type/{id}', 'App\Http\Controllers\TypesController@productTypePost')->name('orders.type.post');

    Route::get('orders/{id}/curtain/model', 'App\Http\Controllers\CurtainsController@addModel')->name('curtain.model');
    Route::post('orders/{id}/curtain/model', 'App\Http\Controllers\CurtainsController@addModelPost')->name('curtain.model.post');

    Route::get('orders/{id}/curtain/cover', 'App\Http\Controllers\CurtainsController@addCover')->name('curtain.cover');
    Route::post('orders/{id}/curtain/cover', 'App\Http\Controllers\CurtainsController@addCoverPost')->name('curtain.cover.post');

    Route::get('orders/{id}/curtain/data', 'App\Http\Controllers\CurtainsController@addData')->name('curtain.data');
    Route::post('orders/{id}/curtain/data', 'App\Http\Controllers\CurtainsController@addDataPost')->name('curtain.data.post');

    Route::get('orders/{id}/curtain/features', 'App\Http\Controllers\CurtainsController@addFeatures')->name('curtain.features');
    Route::post('orders/{id}/curtain/features', 'App\Http\Controllers\CurtainsController@addFeaturesPost')->name('curtain.features.post');

    Route::get('orders/{id}/curtain/review', 'App\Http\Controllers\CurtainsController@review')->name('curtain.review');
    Route::post('orders/{id}/curtain/review', 'App\Http\Controllers\CurtainsController@reviewPost')->name('curtain.review.post');

    Route::get('orders/new', 'App\Http\Controllers\OrdersController@newOrder')->name('orders.new');
    Route::post('orders/new', 'App\Http\Controllers\OrdersController@newOrderPost')->name('orders.new.post');


    Route::resource('admin/canopies', 'App\Http\Controllers\CurtainCanopiesController', ['except' => ['show']]);
    Route::resource('admin/handles', 'App\Http\Controllers\CurtainHandlesController', ['except' => ['show']]);
    Route::resource('admin/models', 'App\Http\Controllers\CurtainModelsController', ['except' => ['show']]);
    Route::resource('admin/covers', 'App\Http\Controllers\CurtainCoversController', ['except' => ['show']]);
    Route::resource('orders', 'App\Http\Controllers\OrdersController');
    Route::resource('curtains', 'App\Http\Controllers\CurtainsController');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

