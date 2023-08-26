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

Route::get('/requests', 'RequestController@index');
Route::get('/requests/{id}', 'RequestController@show');
Route::post('/requests', 'RequestController@store');
Route::put('/requests/{id}', 'RequestController@update');
Route::put('/requests/{id}/change-status', 'RequestController@changeStatus');
Route::delete('/requests/{id}', 'RequestController@destroy');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
