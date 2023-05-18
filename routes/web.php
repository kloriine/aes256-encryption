<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\IndexController;
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

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::post('/encrypt', [IndexController::class, 'encrypt'])->name('encrypt.store');
Route::post('/decrypt', [IndexController::class, 'decrypt'])->name('decrypt.store');

Route::get('/image', [ImageController::class, 'index'])->name('image');
Route::post('/image/encrypt', [ImageController::class, 'encryption'])->name('image.encrypt');
Route::post('/image/decrypt', [ImageController::class, 'decryption'])->name('image.decrypt');