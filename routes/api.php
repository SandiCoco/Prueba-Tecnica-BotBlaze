<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/', function(){
    return 'Hola mundo';
});

Route::get('/productos', 'App\Http\Controllers\ProductController@index');
Route::post('/productos', 'App\Http\Controllers\ProductController@store');
Route::get('/productos/{product}', 'App\Http\Controllers\ProductController@show');
Route::get('/productos/buscar/{name}', 'App\Http\Controllers\ProductController@search');
Route::put('/productos/{product}', 'App\Http\Controllers\ProductController@update');
Route::delete('/productos/{product}', 'App\Http\Controllers\ProductController@destroy');

Route::get('/inventario', 'App\Http\Controllers\InventoryController@index');
Route::post('/inventario', 'App\Http\Controllers\InventoryController@store');