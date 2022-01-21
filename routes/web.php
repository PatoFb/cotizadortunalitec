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

    Route::get('orders/type/{id}', 'App\Http\Controllers\TypesController@productType')->name('orders.type');
    Route::post('orders/type/{id}', 'App\Http\Controllers\TypesController@productTypePost')->name('orders.type.post');

    /*Route::get('orders/{id}/curtain/model', 'App\Http\Controllers\CurtainsController@addModel')->name('curtain.model');
    Route::post('orders/{id}/curtain/model', 'App\Http\Controllers\CurtainsController@addModelPost')->name('curtain.model.post');

    Route::get('orders/{id}/curtain/cover', 'App\Http\Controllers\CurtainsController@addCover')->name('curtain.cover');
    Route::post('orders/{id}/curtain/cover', 'App\Http\Controllers\CurtainsController@addCoverPost')->name('curtain.cover.post');

    Route::get('orders/{id}/curtain/data', 'App\Http\Controllers\CurtainsController@addData')->name('curtain.data');
    Route::post('orders/{id}/curtain/data', 'App\Http\Controllers\CurtainsController@addDataPost')->name('curtain.data.post');

    Route::get('orders/{id}/curtain/features', 'App\Http\Controllers\CurtainsController@addFeatures')->name('curtain.features');
    Route::post('orders/{id}/curtain/features', 'App\Http\Controllers\CurtainsController@addFeaturesPost')->name('curtain.features.post');

    Route::get('orders/{id}/curtain/review', 'App\Http\Controllers\CurtainsController@review')->name('curtain.review');
    Route::post('orders/{id}/curtain/review', 'App\Http\Controllers\CurtainsController@reviewPost')->name('curtain.review.post');*/

    Route::get('orders/{id}/curtain/add', 'App\Http\Controllers\CurtainsController@add')->name('curtain.add');
    Route::post('orders/{id}/curtain/add', 'App\Http\Controllers\CurtainsController@save')->name('curtain.save');

    Route::get('orders/new', 'App\Http\Controllers\OrdersController@newOrder')->name('orders.new');
    Route::post('orders/new', 'App\Http\Controllers\OrdersController@newOrderPost')->name('orders.new.post');

    Route::get('orders/all', 'App\Http\Controllers\OrdersController@all')->name('orders.all');

    Route::get('orders/{id}/details', 'App\Http\Controllers\OrdersController@details')->name('orders.details');

    Route::get('orders/{id}/authorize', 'App\Http\Controllers\OrdersController@production')->name('orders.production');

    Route::get('orders/{id}/send', 'App\Http\Controllers\OrdersController@send')->name('orders.send');

    Route::post('orders/{id}/upload', 'App\Http\Controllers\OrdersController@upload')->name('orders.upload');

    Route::get('orders/{id}/download', 'App\Http\Controllers\OrdersController@download')->name('orders.download');

    Route::post('curtains/fetch/model', 'App\Http\Controllers\CurtainsController@fetchModel')->name('curtain.fetch.model');
    Route::post('curtains/fetch/data', 'App\Http\Controllers\CurtainsController@fetchData')->name('curtain.fetch.data');
    Route::post('curtains/fetch/numbers', 'App\Http\Controllers\CurtainsController@fetchNumbers')->name('curtain.fetch.numbers');

    Route::put('curtains/add_data', 'App\Http\Controllers\CurtainsController@addData')->name('curtain.add.data');

    Route::get('orders/{id}/palilleria/add', 'App\Http\Controllers\PalilleriasController@add')->name('palilleria.add');
    Route::post('orders/{id}/palilleria/add', 'App\Http\Controllers\PalilleriasController@save')->name('palilleria.save');

    Route::post('palillerias/fetch/data', 'App\Http\Controllers\PalilleriasController@fetchData')->name('palilleria.fetch.data');
    Route::post('palillerias/fetch/numbers', 'App\Http\Controllers\PalilleriasController@fetchNumbers')->name('palilleria.fetch.numbers');

    Route::get('orders/{id}/toldo/add', 'App\Http\Controllers\ToldosController@add')->name('toldo.add');
    Route::post('orders/{id}/toldo/add', 'App\Http\Controllers\ToldosController@save')->name('toldo.save');

    Route::post('toldos/fetch/data', 'App\Http\Controllers\ToldosController@fetchData')->name('toldo.fetch.data');
    Route::post('toldos/fetch/numbers', 'App\Http\Controllers\ToldosController@fetchNumbers')->name('toldo.fetch.numbers');
    Route::post('toldos/fetch/projection', 'App\Http\Controllers\ToldosController@fetchProjection')->name('toldo.fetch.projection');

    Route::resource('admin/canopies', 'App\Http\Controllers\CurtainCanopiesController', ['except' => ['show']]);
    Route::resource('admin/handles', 'App\Http\Controllers\CurtainHandlesController', ['except' => ['show']]);
    Route::resource('admin/models', 'App\Http\Controllers\CurtainModelsController', ['except' => ['show']]);
    Route::resource('admin/covers', 'App\Http\Controllers\CurtainCoversController', ['except' => ['show']]);
    Route::resource('admin/tubes', 'App\Http\Controllers\CurtainTubesController', ['except' => ['show']]);
    Route::resource('admin/mechanisms', 'App\Http\Controllers\CurtainMechanismsController', ['except' => ['show']]);
    Route::resource('admin/panels', 'App\Http\Controllers\CurtainPanelsController', ['except' => ['show']]);
    Route::resource('orders', 'App\Http\Controllers\OrdersController');
    Route::resource('curtains', 'App\Http\Controllers\CurtainsController');
    Route::resource('palillerias', 'App\Http\Controllers\PalilleriasController');
    Route::resource('toldos', 'App\Http\Controllers\ToldosController');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

