<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\HelloController2;
use App\Http\Controllers\HelloController3;
use App\Http\Controllers\InputController;
use App\Http\Controllers\ResponseController;
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

Route::get('/name/{id?}', function (string $id){
    return "Name " . $id;
})->name('user-name');

Route::get('/category-name/{id?}', function (string $id){
    return "Category Name " . $id;
})->name('category-name');

Route::get('/user-search/{id}', function ($id){
    $link = route('user-name', [
        "id" => $id
    ]);
    return "Link " . $link;
});

Route::get('/user-search-redirect/{id}', function($id){
    return redirect()->route('user-name', [
        'id' => $id
    ]);
});

Route::get('/controller/hello', [HelloController::class, 'hello']);

Route::get('/controller/hello2/{name}', [HelloController2::class, 'hello']);

Route::get('/controller/hello3/{name}', [HelloController3::class, 'hello']);

Route::get('/controller/request', [HelloController3::class, 'request']);

Route::get('/input/hello', [InputController::class, 'hello']);

Route::post('/input/hello', [InputController::class, 'hello']);

Route::post('/input/hello/first' , [InputController::class, 'helloFirst']);

Route::post('/input/hello/input', [InputController::class, 'helloInput' ]);

Route::post('/input/hello/array', [InputController::class, 'helloArray' ]);

Route::post('/input/type', [InputController::class, 'inputType' ]);

Route::post('/input/filter-only', [InputController::class, 'filterOnly' ]);

Route::post('/input/filter-except', [InputController::class, 'filterExcept' ]);

Route::post('/input/filter-merge', [InputController::class, 'filterMerge']);

Route::post('/file/upload', [FileController::class, 'upload' ]);

Route::get('/response/hello', [ResponseController::class, 'response']);

Route::get('/response/header', [ResponseController::class, 'headerResponse' ]);

Route::get('/response/type/view', [ResponseController::class, 'responseView' ]);

Route::get('/response/type/json', [ResponseController::class, 'responseJson' ]);

Route::get('/response/type/file', [ResponseController::class, 'responseFile' ]);

Route::get('/response/type/download', [ResponseController::class, 'responseDownload' ]);
