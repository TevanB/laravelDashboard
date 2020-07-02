<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

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

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});
/*Route::middleware(['auth:api', 'scope:view-orders'])->get('/orders', function (Request $request) {
    return $request->order();
});*/
//Route::apiResources(['order'=>'API\OrderController']);
Route::group(['middleware' => 'throttle:55,1'], function(){


Route::get("/me", 'API\UserController@getUser');
Route::put("/me", 'API\UserController@updateSelf');
Route::get("/me/{id}", 'API\UserController@getUserByID');
Route::apiResources(['orders'=>'API\OrderController']);
Route::apiResources(['user'=>'API\UserController']);
Route::apiResources(['profile'=>'API\UserController']);

Route::put('order/{id}', 'API\OrderController@claim');
Route::get('orderinfo/{id}', 'API\OrderController@orderInfo');
Route::put('orders', 'API\OrderController@create');
Route::get('profile', 'API\UserController@profile');
//Route::post('profile', 'API\UserController@val');
Route::put('profile', 'API\UserController@updateProfile');
Route::put('payouts', 'API\OrderController@adminPayouts');
Route::put('finished/{id}', 'API\OrderController@markCompleted');
Route::put('payouts/{id}', 'API\OrderController@userPayouts');
Route::get('users/{id}', 'API\UserController@getName');
Route::get('prices', 'API\PricesController@getPrice');
Route::get('prices/{id}', 'API\PricesController@verifyDiscount');
Route::put('reassign/{id}', 'API\OrderController@reassignOrder');
Route::put('reassigned/{id}', 'API\OrderController@markReassigned');
Route::get('accounts', 'API\AccountsController@checkAcc');
Route::put('orderRe', 'API\OrderController@createRe');
Route::put('drop/{id}', 'API\OrderController@dropRequest');
Route::put('requestComplete/{id}', 'API\OrderController@requestComplete');
Route::put('requestAllPayouts/{id}', 'API\OrderController@requestAllPayouts');

Route::post('create-paypal-transaction', 'PaypalRelated\CreateOrder@createOrder');
Route::post('get-paypal-transaction', 'PaypalRelated\GetOrder@getOrder');
Route::post('capture-paypal-transaction', 'PaypalRelated\CaptureOrder@captureOrder');

Route::get('ranks', 'API\RankController@getRank');

Route::get('users', 'API\UserController@index2');
Route::get('ports', 'API\UserController@getPort');
/*
//multiple orders
Route::get('orders', 'API\OrderController@index');
//single order
Route::get('order/{id}', 'API\OrderController@show');
//create order
Route::post('order', 'API\OrderController@store');
//update order
Route::put('order/{id}', 'API\OrderController@store');

//delete order
Route::delete('order/{id}', 'API\OrderController@destroy');
*/

/*Route::get('/user', function () {
    // Access token has both "check-status" and "place-orders" scopes...
    Route::apiResources(['user'=>'API\UserController']);

})->middleware(['auth:api', 'scope:view-orders']);
*/
//Route::apiResources(['user'=>'API\UserController']);
/*Route::group(['middleware' => 'client_credentials'], function () {
//your route

});
*/
});
