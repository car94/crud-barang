<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

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


 
Route::get('/', [BarangController::class, 'index']);
Route::post('store-barang', [BarangController::class, 'store']);
Route::post('edit-barang', [BarangController::class, 'edit']);
Route::post('delete-barang', [BarangController::class, 'destroy']);
