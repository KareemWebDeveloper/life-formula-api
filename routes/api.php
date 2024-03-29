<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactMailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TermsConditionsController;
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
Route::post("/contact" ,  [ContactMailController::class, 'sendEmail']);
Route::post("/register" , [AuthController::class, 'Register']);
Route::get("/categories" , [CategoryController::class, 'getCategories']);
Route::get("/products" , [ProductController::class, 'getProducts']);
Route::get("/product/{id}" , [ProductController::class, 'ProductFind']);
Route::get("/featured" , [ProductController::class, 'getFeaturedProducts']);
Route::get("/terms-conditions" , [TermsConditionsController::class, 'getTermsConditions']);
Route::get("/blog" , [ProductController::class, 'getProductsBlog']);

Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::post("/categories/create" , [CategoryController::class, 'storeCategory']);
    Route::get("/user" ,  [AuthController::class, 'getUser']);
    Route::get("/Logout" ,  [AuthController::class, 'Logout']);
    Route::post("/resetPw" ,  [AuthController::class, 'changePw']);
    Route::get("/userRole" ,  [AuthController::class, 'userRole']);
    Route::get("/users" ,  [AuthController::class, 'getUsers']);
    Route::post("/userRole/update" ,  [AuthController::class, 'updateUserRole']);
    Route::get("/userProfile" ,  [AuthController::class, 'userProfile']);
    Route::post("/userProfile/create" ,  [AuthController::class, 'createProfile']);
    Route::put("/userProfile/update" ,  [AuthController::class, 'updateProfile']);
    Route::post("/productRating" ,  [ProductController::class, 'submitRating']);
    Route::post("/products/create" , [ProductController::class, 'createProduct']);
    Route::put("/products/update/{id}" , [ProductController::class, 'updateProduct']);
    Route::put("/categories/update/{id}" , [CategoryController::class, 'updateCategory']);
    Route::delete("/proudcts/remove/{id}" ,  [ProductController::class, 'destroyProduct']);
    Route::delete("/categories/remove/{id}" ,  [CategoryController::class, 'destroyCategory']);
    Route::post("/addToCart" ,  [CartController::class, 'AddToCart']);
    Route::get("/cart" ,  [CartController::class, 'getUserCart']);
    Route::delete("/cart/delete/{id}" ,  [CartController::class, 'deleteCart']);
    Route::post("/create-checkout-session" , [PaymentController::class, 'createCheckoutSession']);
    Route::get("/orders" , [OrderController::class, 'getOrderWithUserAndItems']);
    Route::post("/terms-conditions/update/{id}" , [TermsConditionsController::class, 'updateTermsConditions']);
    Route::post("/terms-conditions/create" , [TermsConditionsController::class, 'createTermsConditions']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
