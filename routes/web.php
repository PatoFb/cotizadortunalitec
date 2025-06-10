<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('contact', function () {
        return view('contact');
    })->name('contact');
    Route::get('/', function () {
        return redirect()->route('home');
    });
});

Route::group(['middleware' => 'admin'], function () {
    Route::post('admin/users/create', ['as' => 'user.store', 'uses' => 'App\Http\Controllers\UsersController@store']);
    Route::put('admin/user/{id}/password', ['as' => 'user.password', 'uses' => 'App\Http\Controllers\UsersController@password']);
    Route::put('admin/user/{id}/address', ['as' => 'user.address', 'uses' => 'App\Http\Controllers\UsersController@address']);
    Route::put('admin/user/{id}/edit', ['as' => 'user.update', 'uses' => 'App\Http\Controllers\UsersController@update']);

    Route::resource('admin/users', 'App\Http\Controllers\UsersController', ['except' => ['show', 'update']]);
    Route::resource('admin/controls', 'App\Http\Controllers\ControlsController', ['except' => ['show']]);
    Route::resource('admin/types', 'App\Http\Controllers\TypesController', ['except' => ['show']]);

    Route::post('admin/users/search', 'App\Http\Controllers\UsersController@search')->name('users.search');

    Route::get('orders/all', 'App\Http\Controllers\OrdersController@all')->name('orders.all');

    Route::get('orders/record', 'App\Http\Controllers\OrdersController@record')->name('orders.record');

    Route::get('orders/{id}/details', 'App\Http\Controllers\OrdersController@details')->name('orders.details');

    Route::get('orders/{id}/cancel', 'App\Http\Controllers\OrdersController@cancel')->name('orders.cancel');

    Route::get('orders/{id}/authorize', 'App\Http\Controllers\OrdersController@production')->name('orders.production');

    Route::get('orders/{id}/close', 'App\Http\Controllers\OrdersController@close')->name('orders.close');

    Route::get('orders/{id}/send', 'App\Http\Controllers\OrdersController@send')->name('orders.send');

    Route::resource('admin/handles', 'App\Http\Controllers\HandlesController', ['except' => ['show']]);
    Route::resource('admin/models', 'App\Http\Controllers\CurtainModelsController', ['except' => ['show']]);
    Route::resource('admin/covers', 'App\Http\Controllers\CoversController', ['except' => ['show']]);
    Route::resource('admin/mechanisms', 'App\Http\Controllers\MechanismsController', ['except' => ['show']]);

    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::put('profile/address', ['as' => 'profile.address', 'uses' => 'App\Http\Controllers\ProfileController@address']);

});


Route::group(['middleware' => 'user'], function () {
    Route::get('orders/type/{id}', 'App\Http\Controllers\TypesController@productType')->name('orders.type');
    Route::post('orders/type/{id}', 'App\Http\Controllers\TypesController@productTypePost')->name('orders.type.post');

    Route::get('orders/new', 'App\Http\Controllers\OrdersController@newOrder')->name('orders.new');
    Route::post('orders/new', 'App\Http\Controllers\OrdersController@newOrderPost')->name('orders.new.post');

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
    Route::post('curtains/fetch/cover2', 'App\Http\Controllers\CurtainsController@fetchCover2')->name('curtain.fetch.cover2');

    Route::get('curtains/copy/{id}', 'App\Http\Controllers\CurtainsController@copy')->name('curtain.copy');

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
    Route::post('palillerias/fetch/cover2', 'App\Http\Controllers\PalilleriasController@fetchCover2')->name('palilleria.fetch.cover2');

    Route::get('palillerias/copy/{id}', 'App\Http\Controllers\PalilleriasController@copy')->name('palilleria.copy');

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
    Route::post('toldos/fetch/projection', 'App\Http\Controllers\ToldosController@fetchProjection')->name('toldo.fetch.projection');
    Route::post('toldos/fetch/cover2', 'App\Http\Controllers\ToldosController@fetchCover2')->name('toldo.fetch.cover2');

    Route::get('toldos/copy/{id}', 'App\Http\Controllers\ToldosController@copy')->name('toldo.copy');

    Route::put('curtains/data/add', 'App\Http\Controllers\CurtainsController@addData')->name('curtain.data.add');
    Route::put('palillerias/data/add', 'App\Http\Controllers\PalilleriasController@addData')->name('palilleria.data.add');
    Route::put('toldos/data/add', 'App\Http\Controllers\ToldosController@addData')->name('toldo.data.add');

    Route::put('orders/{id}/address', 'App\Http\Controllers\OrdersController@updateAddress')->name('orders.update.address');
    Route::get('orders/{id}/generate', 'App\Http\Controllers\OrdersController@orderPdf')->name('orders.generate');
    Route::get('orders/{id}/make', 'App\Http\Controllers\OrdersController@makeOrder')->name('orders.make');
    Route::post('orders/{id}/upload', 'App\Http\Controllers\OrdersController@upload')->name('orders.upload');
    Route::get('orders/{id}/download', 'App\Http\Controllers\OrdersController@download')->name('orders.download');

    Route::resource('orders', 'App\Http\Controllers\OrdersController');
    Route::resource('curtains', 'App\Http\Controllers\CurtainsController');
    Route::resource('palillerias', 'App\Http\Controllers\PalilleriasController');
    Route::resource('toldos', 'App\Http\Controllers\ToldosController');
});

