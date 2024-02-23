<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix"=>"book"],function(){
    Route::get("/gets",[BookController::class,"gets"]);
    Route::get("/get",[BookController::class,"get"]);
});

Route::group(["prefix"=>"member"],function(){
    Route::get("/gets",[MemberController::class,"gets"]);
    
});

Route::group(["prefix"=>"transaction"],function(){
    Route::post("/store",[TransactionController::class,"store"]);
    Route::get("/getBorrowedBooksInfo",[TransactionController::class,"getBorrowedBooksInfo"]);
    Route::put("/update/{transaction_id}",[TransactionController::class,"update"]);
});
