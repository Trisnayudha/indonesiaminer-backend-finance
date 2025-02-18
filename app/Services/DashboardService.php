<?php

namespace App\Services;

use App\Services\PendapatanService;
use App\Services\PengeluaranService;
use App\Models\Invoice;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    protected $pendapatanService;
    protected $pengeluaranService;

    public function __construct(PendapatanService $pendapatanService, PengeluaranService $pengeluaranService)
    {
        $this->pendapatanService = $pendapatanService;
        $this->pengeluaranService = $pengeluaranService;
    }

    public function getDashboardData()
    {
        // Dapatkan data pendapatan (revenue)
        $weeklyRevenueData = $this->pendapatanService->getWeeklyRevenueData();
        $monthlyRevenueData = $this->pendapatanService->getMonthlyRevenueData();
        $yearlyRevenueData = $this->pendapatanService->getYearlyRevenueData();

        // Dapatkan data pengeluaran (expenses)
        $weeklyExpenses = $this->pengeluaranService->getWeeklyRevenue();
        $monthlyExpenses = $this->pengeluaranService->getMonthlyRevenue();
        $yearlyExpenses = $this->pengeluaranService->getYearlyRevenue();

        // Invoice Data (Current Year)
        $currentYear = now()->year;
        $invoicesThisYear = Invoice::whereYear('invoice_date', $currentYear)->count();
        $invoicesPaidThisYear = Invoice::whereYear('invoice_date', $currentYear)->where('payment_status', 'Paid')->count();
        $invoicesUnpaidThisYear = Invoice::whereYear('invoice_date', $currentYear)->where('payment_status', 'Unpaid')->count();

        // Monthly Revenue & Expenses (untuk line chart)
        $monthlyPendapatan = [];
        $monthlyPengeluaran = [];
        for ($m = 1; $m <= 12; $m++) {
            $start = Carbon::create($currentYear, $m, 1)->startOfMonth();
            $end = Carbon::create($currentYear, $m, 1)->endOfMonth();

            // Pendapatan per bulan
            $monthlyPendapatan[] = $this->pendapatanService->getRevenueForPeriod($start, $end);

            // Pengeluaran per bulan (sesuaikan kolom total dengan milik Anda, misalnya 'total')
            $monthlyPengeluaran[] = Expense::whereBetween('payment_date', [$start, $end])->sum('total');
        }

        // Top Revenue Category (gunakan data dari pendapatan service)
        // Misalnya dari getRevenueForCharts() yang mengembalikan array kategori -> jumlah
        $revenueForCharts = $this->pendapatanService->getRevenueForCharts();
        // $revenueForCharts = ['ticket' => ..., 'exhibitor' => ..., 'sponsor' => ..., 'advertisement' => ...];
        $topRevenueCategory = collect($revenueForCharts)
            ->map(function ($value, $key) {
                return ['category' => ucfirst($key), 'total' => $value];
            })
            ->sortByDesc('total')
            ->values();

        // Expenses by Category (dari tabel Expense)
        // Asumsi kolom 'payment_category' untuk kategori pengeluaran, sum 'total'
        $expenseByCategoryRaw = Expense::select('payment_category', DB::raw('SUM(total) as total_expenses'))
            ->groupBy('payment_category')
            ->get();
        $expenseByCategory = $expenseByCategoryRaw->pluck('total_expenses', 'payment_category')->toArray();

        // Payment Method Distribution pada Invoice
        $paymentMethodRaw = Invoice::select('payment_method', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();
        // Konversi ke persentase
        $totalInvoices = $paymentMethodRaw->sum('count');
        $paymentMethodDistribution = [];
        foreach ($paymentMethodRaw as $pm) {
            $percentage = $totalInvoices > 0 ? round(($pm->count / $totalInvoices) * 100, 2) : 0;
            $paymentMethodDistribution[$pm->payment_method] = $percentage;
        }

        // Revenue By Category (Donut Chart)
        // Kita gunakan $revenueForCharts dari PendapatanService tadi
        // Sudah dalam bentuk array kategori => total revenue
        $revenueByCategory = $revenueForCharts;

        // Top 5 Clients by Invoice Amount
        $topClientsRaw = Invoice::select('client_name', DB::raw('SUM(total_amount) as total_sum'))
            ->groupBy('client_name')
            ->orderBy('total_sum', 'desc')
            ->limit(5)
            ->get();

        $topClients = $topClientsRaw->map(function ($item) {
            return [
                'client_name' => $item->client_name,
                'total_amount' => $item->total_sum
            ];
        });

        // Net Profit Yearly = Yearly Revenue - Yearly Expenses
        $yearlyNetProfit = ($yearlyRevenueData['current_revenue'] ?? 0) - ($yearlyExpenses ?? 0);
        return [
            'weeklyRevenue' => $weeklyRevenueData,
            'monthlyRevenue' => $monthlyRevenueData,
            'yearlyRevenue' => $yearlyRevenueData,

            'weeklyExpenses' => $weeklyExpenses,
            'monthlyExpenses' => $monthlyExpenses,
            'yearlyExpenses' => $yearlyExpenses,

            'invoicesThisYear' => $invoicesThisYear,
            'invoicesPaidThisYear' => $invoicesPaidThisYear,
            'invoicesUnpaidThisYear' => $invoicesUnpaidThisYear,

            'monthlyPendapatan' => $monthlyPendapatan,
            'monthlyPengeluaran' => $monthlyPengeluaran,

            'topRevenueCategory' => $topRevenueCategory,
            'topClients' => $topClients,
            'paymentMethodDistribution' => $paymentMethodDistribution,
            'revenueByCategory' => $revenueByCategory,
            'expenseByCategory' => $expenseByCategory,
            'yearlyNetProfit' => $yearlyNetProfit,
        ];
    }
}
