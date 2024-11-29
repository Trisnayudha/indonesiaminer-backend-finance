<?php

namespace App\Http\Controllers;

use App\Services\PengeluaranService;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    protected $pengeluaranService;

    // Inisialisasi service
    public function __construct(PengeluaranService $pengeluaranService)
    {
        $this->pengeluaranService = $pengeluaranService;
    }

    public function index()
    {
        // Get revenue data
        $weeklyRevenue = $this->pengeluaranService->getWeeklyRevenue();
        $monthlyRevenue = $this->pengeluaranService->getMonthlyRevenue();
        $yearlyRevenue = $this->pengeluaranService->getYearlyRevenue();

        // Get chart data
        $barChartData = $this->pengeluaranService->getExpenseBarChartData();
        $pieChartData = $this->pengeluaranService->getExpensePieChartData();
        $getData = $this->pengeluaranService->getAll();
        return view('pengeluaran.index', [
            'weeklyRevenue' => $weeklyRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'yearlyRevenue' => $yearlyRevenue,
            'barChartData' => $barChartData,
            'pieChartData' => $pieChartData,
            'getData' => $getData
        ]);
    }
}
