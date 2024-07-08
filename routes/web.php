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

Route::get('/johntakpor', function() {
    return "Hello Johntakpor";
});

Route::redirect('/youtube', '/johntakpor');

Route::fallback(function () {
	return "404 this is fallback";
});

Route::view("/hello", "hello",  ["name" => "hello"]);

Route::get("/hello-again", function () {
    return view("hello", [ "name" => "Johnson"]);
});

Route::get("/hello-world", function () {
    return view("hello.world", [ "name" => "World"]);
});

Route::get("/products/{productId}", function ($productId){
    return "products : " . $productId;
});

Route::get("/products/{product}/items/{items}", function ($productId, $itemId){
    return "Products : " . $productId . ", Items : " . $itemId;
});

Route::get('/categories/{id}', function (string $categoryId){
    return "Categories : " . $categoryId;
})->where("id" , '[0-9]+');

Route::get('/users/{id?}', function (string $userId){
    return "Users : " . $userId;
});

Route::get("/conflict/johntakpor", function(){
    return 'Conflict with Johntakpor';
});

Route::get("/conflict/{nameId}", function(string $nameId){
    return "Conflict " . $nameId;
});
