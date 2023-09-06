<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
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

Route::post("/login" ,  [AuthController::class, 'login']);
Route::post("/register" , [AuthController::class, 'Register']);
Route::get("/categories" , [CategoryController::class, 'getCategories']);
Route::get("/products" , [ProductController::class, 'getProducts']);
Route::get("/product/{id}" , [ProductController::class, 'ProductFind']);
Route::get("/featured" , [ProductController::class, 'getFeaturedProducts']);

Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::post("/categories/create" , [CategoryController::class, 'storeCategory']);
    Route::get("/user" ,  [AuthController::class, 'getUser']);
    Route::get("/Logout" ,  [AuthController::class, 'Logout']);
    Route::post("/resetPw" ,  [AuthController::class, 'changePw']);
    Route::get("/userRole" ,  [AuthController::class, 'userRole']);
    Route::get("/userProfile" ,  [AuthController::class, 'userProfile']);
    Route::post("/userProfile/create" ,  [AuthController::class, 'createProfile']);
    Route::put("/userProfile/update" ,  [AuthController::class, 'updateProfile']);
    Route::post("/productRating" ,  [ProductController::class, 'submitRating']);
    Route::post("/products/create" , [ProductController::class, 'createProduct']);
    Route::put("/products/update/{id}" , [ProductController::class, 'updateProduct']);
    Route::delete("/proudcts/remove/{id}" ,  [ProductController::class, 'destroyProduct']);
    Route::post("/addToCart" ,  [CartController::class, 'AddToCart']);
    Route::get("/cart" ,  [CartController::class, 'getUserCart']);
    Route::delete("/cart/delete/{id}" ,  [CartController::class, 'deleteCart']);
    Route::post("/create-checkout-session" , [PaymentController::class, 'createCheckoutSession']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
