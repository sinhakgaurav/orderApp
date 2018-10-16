<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::get('/orders', 'OrderController@orders')->name('orderlist');
Route::post('/order', 'OrderController@store');
Route::put('/order/{id}', 'OrderController@update');
Route::delete('/delete/{id}', 'OrderController@delete');*/

$router->group(['middleware' => 'auth.token'], function () use ($router) {
  $router->get('/orders',  ['uses' => 'OrderController@orders']);

  $router->post('/order', ['uses' => 'OrderController@store']);

  $router->put('/order/{id}', ['uses' => 'OrderController@update']);

  $router->delete('/delete/{id}', ['uses' => 'OrderController@delete']);
});
