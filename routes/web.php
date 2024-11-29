<?php

use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', [TestController::class, 'index']);

Route::get('/', function () {
    return view('dashboard.index');
});

Route::get('/invoice', function () {
    return view('invoice.index');
});
Route::get('/report', function () {
    return view('report.index');
});
Route::get('/analytic', function () {
    return view('analytic.index');
});

Route::get('/pendapatan', [PendapatanController::class, 'index']);

Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
