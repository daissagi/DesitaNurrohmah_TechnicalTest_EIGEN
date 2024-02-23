<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/docs', function () {
    return view('index');
});

// Route::get('/book', [BookController::class, 'index']);
// Route::get('/member', [MemberController::class, 'index']);
// Route::get('/transaction', [MemberController::class, 'index']);

Route::post('/book',[TransactionController::class,'borrowBook']);
Route::post('/member',[TransactionController::class,'returnBook']);
Route::get('/book',[TransactionController::class,'books']);
Route::get('/member',[TransactionController::class,'members']);

