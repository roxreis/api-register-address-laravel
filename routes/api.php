<?php

use App\Http\Controllers\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/addresses/list', [AddressController::class, 'getAddresses']);
Route::get('/address/{id}', [AddressController::class, 'getAddress']);
Route::get('search/address/{zipCode}', [AddressController::class, 'getAddressByZipcode']);
Route::post('/address', [AddressController::class, 'postAddress']);
Route::put('/address/{id}', [AddressController::class, 'putAddress']);
Route::delete('/address/{id}', [AddressController::class, 'deleteAddress']);
