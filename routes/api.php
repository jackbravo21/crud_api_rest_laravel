<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/ok", function(){
        return ["status" => true];
});

//namespace significa que vai ter todo o namespace do laravel, mais o apelido(name), e o agrupamento group que coloca sobre o guardachuva do endereco API;
Route::namespace("API")->name("api")->group(function(){
    
    //tudo que tiver dentro do meu group products, vai receber o prefixo products;
    Route::prefix("products")->group(function(){
        
        Route::get("/", "ProductController@index")->name("products");
        Route::get("/{id}", "ProductController@show")->name("single_products");

        Route::post("/", "ProductController@store")->name("store_products");

        Route::put("/{id}", "ProductController@update")->name("update_products");

        Route::delete("/{id}", "ProductController@delete")->name("delete_products");
    });
});