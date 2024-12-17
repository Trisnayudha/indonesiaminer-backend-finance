<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
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

// Route untuk Login, Logout (Tidak memerlukan autentikasi)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Semua Route Wajib Login
Route::middleware(['auth'])->group(function () {

    // Route Test
    Route::get('/test', [TestController::class, 'index']);

    // Dashboard
    Route::get('/', [DashboardController::class, 'index']);

    // Rute untuk daftar invoice
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/{id}/detail', [InvoiceController::class, 'detail'])->name('invoice.detail');
    Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::get('/invoice/{id}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoice.downloadPdf');
    Route::get('/invoice/latest-rate', [InvoiceController::class, 'getLatestRate'])->name('invoice.latestRate');

    // Report dan Analytic
    Route::get('/report', function () {
        return view('report.index');
    });
    Route::get('/analytic', function () {
        return view('analytic.index');
    });

    // Rute Pendapatan
    Route::get('/pendapatan', [PendapatanController::class, 'index']);

    // Resource Routes untuk Pengeluaran
    Route::resource('pengeluaran', PengeluaranController::class);

    // Export Data
    Route::get('/pengeluaran/export/csv', [PengeluaranController::class, 'exportCsv'])->name('pengeluaran.export.csv');
    Route::get('/pengeluaran/export/pdf', [PengeluaranController::class, 'exportPdf'])->name('pengeluaran.export.pdf');
});
