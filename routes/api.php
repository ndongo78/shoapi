<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NewLetterController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\MesclientsController;
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
Route::post("/adInfo",[LoginController::class,'adInfos']);
Route::post("/updatePassword",[LoginController::class,'updatePassword']);
Route::post("/resetPassword",[LoginController::class,'resetPassword']);
Route::post("/getInfo",[LoginController::class,'getInfo']);
Route::post("/newletter",[NewLetterController::class,'store']);



Route::post('/getByid',[ArticleController::class,'getByid']);
Route::get('/getChaussures',[ArticleController::class,'getChaussures']);
Route::get('/getLastAcs',[ArticleController::class,'getLastAcs']);
Route::get('/getLast',[ArticleController::class,'getLast']);
Route::get('/getLastVet',[ArticleController::class,'getLastVet']);
Route::get('/getVetements',[ArticleController::class,'getVetements']);
Route::get('/getAccessoires',[ArticleController::class,'getAccessoires']);

Route::get('/categories',[CategoryController::class,'index']);
Route::get('/articles',[ArticleController::class,'index']);



//route pour crud admin
Route::middleware('shop_auth')->group(function(){
    Route::post('/postCategory',[CategoryController::class,'store']);
    Route::put('/category/{category}/update',[CategoryController::class,'update']);
    Route::delete('/category/{category}/delete',[CategoryController::class,'destroy']);

    //
    Route::post('/postArticle',[ArticleController::class,'store']);
    Route::post('/editArticle',[ArticleController::class,'editArticle']);
    Route::post('/updateArticle',[ArticleController::class,'update']);
   Route::delete('/{article}/delete',[ArticleController::class,'destroy']);
   Route::post("/updateUserInfos",[RegisterController::class,'updateUserInfos']);
   Route::post("/commande",[CommandeController::class,'store']);
   Route::post("/getCommande",[CommandeController::class,'getCommande']);
   Route::get("/mesclients",[LoginController::class,'index']);
   Route::post("/promo",[PromotionController::class,'update']);
   Route::get("/verifyUserForResetPassword/{id}",[LoginController::class,'verifyUserForResetPassword']);
   Route::post("/updateForgotPassword",[LoginController::class,'updateForgotPassword']);
   
   Route::get('/getAllCommandes',[CommandeController::class,'index']);
   Route::get('/getAllMessages',[MesclientsController::class,'index']);
   Route::post("/postMessage",[MesclientsController::class,'store']);
   Route::post("/postFavorite",[FavoriteController::class,'store']);
   Route::post("/getFavorite",[FavoriteController::class,'getFavorite']);
   Route::get("/getPromo",[PromotionController::class,'index']);
});

Route::get('/password/reset/mail/{react_token}', [LoginController::class, "resetPasswordView"]);
