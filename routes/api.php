<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/register.store",[RegisterController::class,'store']);
Route::post("/login",[LoginController::class,'connect']);



Route::post('/getByid',[ArticleController::class,'getByid']);
Route::get('/getChaussures',[ArticleController::class,'getChaussures']);
Route::get('/getLastAcs',[ArticleController::class,'getLastAcs']);
Route::get('/getLast',[ArticleController::class,'getLast']);
Route::get('/getLastVet',[ArticleController::class,'getLastVet']);
Route::get('/getVetements',[ArticleController::class,'getVetements']);
Route::get('/getAccessoires',[ArticleController::class,'getAccessoires']);

Route::get('/getCategory',[CategoryController::class,'index']);
Route::get('/getArticle',[ArticleController::class,'index']);
//route pour crud admin
Route::middleware('shop_auth')->group(function(){
    Route::post('/postCategory',[CategoryController::class,'store']);
    Route::post('/postArticle',[ArticleController::class,'store']);
});