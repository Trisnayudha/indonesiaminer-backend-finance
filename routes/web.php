<?php

use App\Http\Controllers\InvoiceController;
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

// Rute untuk daftar invoice
Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
// Rute untuk menyimpan invoice baru
Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
// Rute untuk menampilkan detail invoice
Route::get('/invoice/{id}/detail', [InvoiceController::class, 'detail'])->name('invoice.detail');
// Rute untuk menampilkan form edit invoice
Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
// Rute untuk memperbarui invoice
Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('invoice.update');
// Rute untuk menghapus invoice
Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
// Rute untuk mengunduh PDF invoice
Route::get('/invoice/{id}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoice.downloadPdf');
Route::get('/invoice/latest-rate', [InvoiceController::class, 'getLatestRate'])->name('invoice.latestRate');

Route::get('/report', function () {
    return view('report.index');
});
Route::get('/analytic', function () {
    return view('analytic.index');
});

Route::get('/pendapatan', [PendapatanController::class, 'index']);

// Resource Routes
Route::resource('pengeluaran', PengeluaranController::class);

// Route Tambahan untuk Export Data (Contoh)
Route::get('/pengeluaran/export/csv', [PengeluaranController::class, 'exportCsv'])->name('pengeluaran.export.csv');
Route::get('/pengeluaran/export/pdf', [PengeluaranController::class, 'exportPdf'])->name('pengeluaran.export.pdf');
