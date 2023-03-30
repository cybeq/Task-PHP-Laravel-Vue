<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/read/{model}/{id?}', [\App\Http\Controllers\CrudController::class, 'read']);
Route::post('/create/{model}/', [\App\Http\Controllers\CrudController::class, 'create']);
Route::put('/update/{model}/{id}/', [\App\Http\Controllers\CrudController::class, 'update']);
Route::delete('/delete/{model}/{id}', [\App\Http\Controllers\CrudController::class, 'delete']);
Route::get('/many/car/client/{client_id}', [App\Http\Controllers\CrudController::class, 'getCarsByClient']);
Route::get('/many/order/client/{client_id}', [App\Http\Controllers\CrudController::class, 'getOrdersByClient']);
