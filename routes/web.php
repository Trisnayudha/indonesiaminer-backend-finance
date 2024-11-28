<?php

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

Route::get('/test', function () {
    return view('pdf.template-receipt');
});

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

Route::get('/pendapatan', function () {
    return view('pendapatan.index');
});

Route::get('/pengeluaran', function () {
    return view('pengeluaran.index');
});
