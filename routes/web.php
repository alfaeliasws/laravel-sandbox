<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormViewController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\HelloController2;
use App\Http\Controllers\HelloController3;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\ExampleMiddleware;
use App\Http\Middleware\ExampleParamMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::get('/response-before/type/view', [ResponseController::class, 'responseView' ]);

Route::get('/response-before/type/json', [ResponseController::class, 'responseJson' ]);

Route::get('/response-before/type/file', [ResponseController::class, 'responseFile' ]);

Route::get('/response-before/type/download', [ResponseController::class, 'responseDownload' ]);

// GROUPED BELOW
Route::get('/cookies/set', [CookieController::class, 'createCookie']);

Route::get('/cookies/get', [CookieController::class, 'getCookie']);

Route::get('/cookies/clear', [CookieController::class, 'clearCookie']);

Route::get('/redirect/from', [RedirectController::class, 'redirectFrom']);

Route::get('/redirect/to', [RedirectController::class, 'redirectTo']);

Route::get('/redirect/name', [RedirectController::class, 'redirectName']);

Route::get('/redirect/name/{name}', [RedirectController::class, 'redirectHello'])->name("redirect-hello");

Route::get('/redirect/action', [RedirectController::class, 'redirectAction']);

Route::get('/redirect/away', [RedirectController::class, 'redirectAway']);

Route::get('/middleware/api', function(){return "OK";})->middleware(['example']);

Route::get('/middleware/api2', function(){return "OK";})->middleware([ExampleMiddleware::class]);

Route::get('/middleware/group', function(){return "GROUP";})->middleware([ExampleMiddleware::class]);

Route::get('/middleware/api3', function(){return "OK";})->middleware(['param:john,401']);

Route::get('/middleware/group2', function(){return "GROUP";})->middleware(['param:john,401']);

Route::post('/file/upload/without', [FileController::class, 'upload' ])->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/form', [FormViewController::class, 'form']);

Route::post('/form', [FormViewController::class, 'submitForm' ]);

Route::prefix('/response/type')->group(function(){
    Route::get('/view', [ResponseController::class, 'responseView' ]);
    Route::get('/json', [ResponseController::class, 'responseJson' ]);
    Route::get('/file', [ResponseController::class, 'responseFile' ]);
    Route::get('/download', [ResponseController::class, 'responseDownload' ]);
});

Route::middleware(['param:john,401'])->group(function(){
    Route::get('/middleware/group2', function(){ return "GROUP";});
});


Route::middleware(['param:john,401'])->prefix('/middleware')->group(function () {
    Route::get('/api3', function () {
        return "OK";
    });
});

Route::get('/url/current', function(){return URL::full();});

// CONTROLLER GROUP NOT WORKING
// Route::controller(CookieController::class)->group(
//     function(){
//         Route::get('/coookies/set', 'createCookie');
//         Route::get('/coookies/get', 'getCookie');
//         Route::get('/coookies/clear', 'clearCookie');
//     }
// );

Route::get('/url/named', function(){return route('redirect-hello', ['name' => 'Justin']);});

Route::get('/url/action', function(){
    
    return URL::action([FormViewController::class, 'form'], []);
    // return url()->action([FormViewController::class, 'form'], []);
    // return action([FormViewController::class, 'form'], []);
});

Route::get('/session/create', [SessionController::class, 'createSession']);

Route::get('/session/get', [SessionController::class, 'getSession']);

Route::get('/error/sample', function(){throw new Exception("Sample Error");});

Route::get('/error/manuale', function(){
    report(new Exception("Manual Error Reporting"));
    return "OK";
});

Route::get('/error/validation', function(){
    throw new ValidationException("Validation Error");
});

Route::get('/abort/400-withoutpage', function(){
    abort(400);
});


Route::get('/abort/400', function(){
    abort(400, "Oow, Validation Error Happens!");
});

Route::get('/abort/401', function(){
    abort(401);
});

Route::get('/abort/500', function(){
    abort(500);
});

