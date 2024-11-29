<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PendapatanService;

class PendapatanController extends Controller
{
    protected $pendapatanService;

    // Dependency Injection untuk PendapatanService
    public function __construct(PendapatanService $pendapatanService)
    {
        $this->pendapatanService = $pendapatanService;
    }

    public function index(Request $request)
    {
        // Mendapatkan data pendapatan tahunan untuk chart
        $revenueByCategory = $this->pendapatanService->getRevenueForCharts();
        $yearlyRevenueByCategory = $this->pendapatanService->getYearlyRevenueByCategoryForLineChart();
        $allRevenueData = $this->pendapatanService->getAllRevenueData();
        // Mendapatkan data pendapatan mingguan, bulanan, dan tahunan untuk card statistics
        $weeklyRevenue = $this->pendapatanService->getWeeklyRevenueData();
        $monthlyRevenue = $this->pendapatanService->getMonthlyRevenueData();
        $yearlyRevenue = $this->pendapatanService->getYearlyRevenueData();

        // Menyediakan data untuk view
        return view('pendapatan.index', [
            'revenueByCategory' => $revenueByCategory,
            'yearlyRevenueByCategory' => $yearlyRevenueByCategory,
            'weeklyRevenue' => $weeklyRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'yearlyRevenue' => $yearlyRevenue,
            'allRevenueData' => $allRevenueData
        ]);
    }
}
