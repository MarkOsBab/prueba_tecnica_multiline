<?php

use App\Http\Controllers\CallController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('llamadas')->group(function() {
    Route::get('create', [CallController::class, 'create'])->name('calls.create');
    Route::post('store', [CallController::class, 'store'])->name('calls.store');
});