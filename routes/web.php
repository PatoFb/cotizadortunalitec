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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('contact', function () {
        return view('contact');
    })->name('contact');
});

Route::group(['middleware' => 'auth'], function () {

});

Route::group(['middleware' => 'admin'], function () {
    Route::resource('admin/users', 'App\Http\Controllers\UsersController', ['except' => ['show']]);
    Route::resource('admin/controls', 'App\Http\Controllers\CurtainControlsController', ['except' => ['show']]);
    Route::resource('admin/types', 'App\Http\Controllers\TypesController', ['except' => ['show']]);

    Route::post('admin/users/search', 'App\Http\Controllers\UsersController@search')->name('users.search');

    Route::get('orders/all', 'App\Http\Controllers\OrdersController@all')->name('orders.all');

    Route::get('orders/{id}/details', 'App\Http\Controllers\OrdersController@details')->name('orders.details');

    Route::get('orders/{id}/authorize', 'App\Http\Controllers\OrdersController@production')->name('orders.production');

    Route::post('orders/{id}/upload', 'App\Http\Controllers\OrdersController@upload')->name('orders.upload');

    Route::get('orders/{id}/download', 'App\Http\Controllers\OrdersController@download')->name('orders.download');

    Route::get('orders/{id}/send', 'App\Http\Controllers\OrdersController@send')->name('orders.send');

    Route::resource('admin/canopies', 'App\Http\Controllers\CurtainCanopiesController', ['except' => ['show']]);
    Route::resource('admin/handles', 'App\Http\Controllers\CurtainHandlesController', ['except' => ['show']]);
    Route::resource('admin/models', 'App\Http\Controllers\CurtainModelsController', ['except' => ['show']]);
    Route::resource('admin/covers', 'App\Http\Controllers\CurtainCoversController', ['except' => ['show']]);
    Route::resource('admin/tubes', 'App\Http\Controllers\CurtainTubesController', ['except' => ['show']]);
    Route::resource('admin/mechanisms', 'App\Http\Controllers\CurtainMechanismsController', ['except' => ['show']]);
    Route::resource('admin/panels', 'App\Http\Controllers\CurtainPanelsController', ['except' => ['show']]);

});


Route::group(['middleware' => 'user'], function () {
    Route::get('orders/type/{id}', 'App\Http\Controllers\TypesController@productType')->name('orders.type');
    Route::post('orders/type/{id}', 'App\Http\Controllers\TypesController@productTypePost')->name('orders.type.post');

    Route::get('orders/new', 'App\Http\Controllers\OrdersController@newOrder')->name('orders.new');
    Route::post('orders/new', 'App\Http\Controllers\OrdersController@newOrderPost')->name('orders.new.post');

    Route::get('orders/{id}/curtain/add', 'App\Http\Controllers\CurtainsController@add')->name('curtain.add');
    Route::post('orders/{id}/curtain/add', 'App\Http\Controllers\CurtainsController@save')->name('curtain.save');

    Route::get('orders/{id}/screeny/add', 'App\Http\Controllers\ScreenyCurtainsController@add')->name('screeny.add');
    Route::post('orders/{id}/screeny/add', 'App\Http\Controllers\ScreenyCurtainsController@save')->name('screeny.save');

    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::put('profile/address', ['as' => 'profile.address', 'uses' => 'App\Http\Controllers\ProfileController@address']);

    Route::get('curtains/model/{id}', 'App\Http\Controllers\CurtainsController@addModel')->name('curtain.model');
    Route::post('curtains/model/{id}', 'App\Http\Controllers\CurtainsController@addModelPost')->name('curtain.model.post');

    Route::get('curtains/cover/{id}', 'App\Http\Controllers\CurtainsController@addCover')->name('curtain.cover');
    Route::post('curtains/cover/{id}', 'App\Http\Controllers\CurtainsController@addCoverPost')->name('curtain.cover.post');

    Route::get('curtains/data/{id}', 'App\Http\Controllers\CurtainsController@addDat')->name('curtain.data');
    Route::post('curtains/data/{id}', 'App\Http\Controllers\CurtainsController@addDataPost')->name('curtain.data.post');

    Route::get('curtains/features/{id}', 'App\Http\Controllers\CurtainsController@addFeatures')->name('curtain.features');
    Route::post('curtains/features/{id}', 'App\Http\Controllers\CurtainsController@addFeaturesPost')->name('curtain.features.post');

    Route::get('curtains/review/{id}', 'App\Http\Controllers\CurtainsController@review')->name('curtain.review');
    Route::post('curtains/review/{id}', 'App\Http\Controllers\CurtainsController@reviewPost')->name('curtain.review.post');

    Route::post('curtains/fetch/cover', 'App\Http\Controllers\CurtainsController@fetchCover')->name('curtain.fetch.cover');

    Route::get('palillerias/model/{id}', 'App\Http\Controllers\PalilleriasController@addModel')->name('palilleria.model');
    Route::post('palillerias/model/{id}', 'App\Http\Controllers\PalilleriasController@addModelPost')->name('palilleria.model.post');

    Route::get('palillerias/cover/{id}', 'App\Http\Controllers\PalilleriasController@addCover')->name('palilleria.cover');
    Route::post('palillerias/cover/{id}', 'App\Http\Controllers\PalilleriasController@addCoverPost')->name('palilleria.cover.post');

    Route::get('palillerias/data/{id}', 'App\Http\Controllers\PalilleriasController@addDat')->name('palilleria.data');
    Route::post('palillerias/data/{id}', 'App\Http\Controllers\PalilleriasController@addDataPost')->name('palilleria.data.post');

    Route::get('palillerias/features/{id}', 'App\Http\Controllers\PalilleriasController@addFeatures')->name('palilleria.features');
    Route::post('palillerias/features/{id}', 'App\Http\Controllers\PalilleriasController@addFeaturesPost')->name('palilleria.features.post');

    Route::get('palillerias/review/{id}', 'App\Http\Controllers\PalilleriasController@review')->name('palilleria.review');
    Route::post('palillerias/review/{id}', 'App\Http\Controllers\PalilleriasController@reviewPost')->name('palilleria.review.post');

    Route::post('palillerias/fetch/cover', 'App\Http\Controllers\PalilleriasController@fetchCover')->name('palilleria.fetch.cover');

    Route::get('toldos/model/{id}', 'App\Http\Controllers\ToldosController@addModel')->name('toldo.model');
    Route::post('toldos/model/{id}', 'App\Http\Controllers\ToldosController@addModelPost')->name('toldo.model.post');

    Route::get('toldos/cover/{id}', 'App\Http\Controllers\ToldosController@addCover')->name('toldo.cover');
    Route::post('toldos/cover/{id}', 'App\Http\Controllers\ToldosController@addCoverPost')->name('toldo.cover.post');

    Route::get('toldos/data/{id}', 'App\Http\Controllers\ToldosController@addDat')->name('toldo.data');
    Route::post('toldos/data/{id}', 'App\Http\Controllers\ToldosController@addDataPost')->name('toldo.data.post');

    Route::get('toldos/features/{id}', 'App\Http\Controllers\ToldosController@addFeatures')->name('toldo.features');
    Route::post('toldos/features/{id}', 'App\Http\Controllers\ToldosController@addFeaturesPost')->name('toldo.features.post');

    Route::get('toldos/review/{id}', 'App\Http\Controllers\ToldosController@review')->name('toldo.review');
    Route::post('toldos/review/{id}', 'App\Http\Controllers\ToldosController@reviewPost')->name('toldo.review.post');

    Route::post('toldos/fetch/cover', 'App\Http\Controllers\ToldosController@fetchCover')->name('toldo.fetch.cover');

    Route::resource('orders', 'App\Http\Controllers\OrdersController');
    Route::resource('curtains', 'App\Http\Controllers\CurtainsController');
    Route::resource('screeny', 'App\Http\Controllers\ScreenyCurtainsController');
    Route::resource('palillerias', 'App\Http\Controllers\PalilleriasController');
    Route::resource('toldos', 'App\Http\Controllers\ToldosController');

    Route::post('curtains/fetch/model', 'App\Http\Controllers\CurtainsController@fetchModel')->name('curtain.fetch.model');
    Route::post('curtains/fetch/data', 'App\Http\Controllers\CurtainsController@fetchData')->name('curtain.fetch.data');
    Route::post('curtains/fetch/numbers', 'App\Http\Controllers\CurtainsController@fetchNumbers')->name('curtain.fetch.numbers');
    Route::post('curtains/fetch/accesories', 'App\Http\Controllers\CurtainsController@fetchAccesories')->name('curtain.fetch.accesories');
    Route::post('curtains/fetch/controls', 'App\Http\Controllers\CurtainsController@fetchControls')->name('curtain.fetch.controls');
    Route::post('curtains/fetch/voices', 'App\Http\Controllers\CurtainsController@fetchVoices')->name('curtain.fetch.voices');


    Route::post('screeny/fetch/model', 'App\Http\Controllers\ScreenyCurtainsController@fetchModel')->name('screeny.fetch.model');
    Route::post('screeny/fetch/data', 'App\Http\Controllers\ScreenyCurtainsController@fetchData')->name('screeny.fetch.data');
    Route::post('screeny/fetch/numbers', 'App\Http\Controllers\ScreenyCurtainsController@fetchNumbers')->name('screeny.fetch.numbers');
    Route::post('screeny/fetch/accesories', 'App\Http\Controllers\ScreenyCurtainsController@fetchAccesories')->name('screeny.fetch.accesories');
    Route::post('screeny/fetch/controls', 'App\Http\Controllers\ScreenyCurtainsController@fetchControls')->name('screeny.fetch.controls');
    Route::post('screeny/fetch/voices', 'App\Http\Controllers\ScreenyCurtainsController@fetchVoices')->name('screeny.fetch.voices');

    Route::put('curtains/add_data', 'App\Http\Controllers\CurtainsController@addData')->name('curtain.add.data');

    Route::put('screeny/add_data', 'App\Http\Controllers\ScreenyCurtainsController@addData')->name('screeny.add.data');

    Route::get('orders/{id}/palilleria/add', 'App\Http\Controllers\PalilleriasController@add')->name('palilleria.add');
    Route::post('orders/{id}/palilleria/add', 'App\Http\Controllers\PalilleriasController@save')->name('palilleria.save');

    Route::post('palillerias/fetch/data', 'App\Http\Controllers\PalilleriasController@fetchData')->name('palilleria.fetch.data');
    Route::post('palillerias/fetch/numbers', 'App\Http\Controllers\PalilleriasController@fetchNumbers')->name('palilleria.fetch.numbers');
    Route::post('palillerias/fetch/accessories', 'App\Http\Controllers\PalilleriasController@fetchAccessories')->name('palilleria.fetch.accessories');
    Route::post('palillerias/fetch/controls', 'App\Http\Controllers\PalilleriasController@fetchControls')->name('palilleria.fetch.controls');
    Route::post('palillerias/fetch/voices', 'App\Http\Controllers\PalilleriasController@fetchVoices')->name('palilleria.fetch.voices');

    Route::get('orders/{id}/toldo/add', 'App\Http\Controllers\ToldosController@add')->name('toldo.add');
    Route::post('orders/{id}/toldo/add', 'App\Http\Controllers\ToldosController@save')->name('toldo.save');

    Route::post('toldos/fetch/data', 'App\Http\Controllers\ToldosController@fetchData')->name('toldo.fetch.data');
    Route::post('toldos/fetch/numbers', 'App\Http\Controllers\ToldosController@fetchNumbers')->name('toldo.fetch.numbers');
    Route::post('toldos/fetch/projection', 'App\Http\Controllers\ToldosController@fetchProjection')->name('toldo.fetch.projection');
    Route::post('toldos/fetch/controls', 'App\Http\Controllers\ToldosController@fetchControls')->name('toldo.fetch.controls');
    Route::post('toldos/fetch/voices', 'App\Http\Controllers\ToldosController@fetchVoices')->name('toldo.fetch.voices');
    Route::post('toldos/fetch/accesories', 'App\Http\Controllers\ToldosController@fetchAccesories')->name('toldo.fetch.accesories');
});

