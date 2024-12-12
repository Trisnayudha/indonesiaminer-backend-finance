<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\PaymentAdvertisement;
use App\Models\PaymentExhibitor;
use App\Models\PaymentSponsor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PendapatanService
{
    // Mendapatkan data pendapatan mingguan dan menghitung persentase perubahan
    public function getWeeklyRevenueData()
    {
        // Mendapatkan pendapatan minggu ini
        $currentWeeklyRevenue = $this->getRevenueForPeriod(now()->subDays(7), now());

        // Mendapatkan pendapatan minggu lalu
        $previousWeeklyRevenue = $this->getRevenueForPeriod(now()->subDays(14), now()->subDays(7));

        // Menghitung persentase perubahan
        $percentageChange = $this->calculatePercentageChange($previousWeeklyRevenue, $currentWeeklyRevenue);

        // Return data for chart purposes (Line and Pie)
        return [
            'current_revenue' => $currentWeeklyRevenue,
            'previous_revenue' => $previousWeeklyRevenue,
            'percentage_change' => $percentageChange,
            'revenue_by_category' => $this->getRevenueByCategory(now()->subDays(7), now()) // Data for Pie chart
        ];
    }

    // Mendapatkan data pendapatan bulanan dan menghitung persentase perubahan
    public function getMonthlyRevenueData()
    {
        $currentMonthlyRevenue = $this->getRevenueForPeriod(now()->startOfMonth(), now());
        $previousMonthlyRevenue = $this->getRevenueForPeriod(now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth());
        $percentageChange = $this->calculatePercentageChange($previousMonthlyRevenue, $currentMonthlyRevenue);

        return [
            'current_revenue' => $currentMonthlyRevenue,
            'previous_revenue' => $previousMonthlyRevenue,
            'percentage_change' => $percentageChange,
            'revenue_by_category' => $this->getRevenueByCategory(now()->startOfMonth(), now()) // Data for Pie chart
        ];
    }

    // Mendapatkan data pendapatan tahunan dan menghitung persentase perubahan
    public function getYearlyRevenueData()
    {
        $currentYearlyRevenue = $this->getRevenueForPeriod(now()->startOfYear(), now());
        $previousYearlyRevenue = $this->getRevenueForPeriod(now()->subYear()->startOfYear(), now()->subYear()->endOfYear());

        $percentageChange = $this->calculatePercentageChange($previousYearlyRevenue, $currentYearlyRevenue);

        return [
            'current_revenue' => $currentYearlyRevenue,
            'previous_revenue' => $previousYearlyRevenue,
            'percentage_change' => $percentageChange,
            'revenue_by_category' => $this->getRevenueByCategory(now()->startOfYear(), now()) // Data for Pie chart
        ];
    }

    // Menghitung total pendapatan dalam periode tertentu
    private function getRevenueForPeriod($startDate, $endDate)
    {
        return DB::connection('mysql_miner')->table('payment')->where('status', 'Paid Off')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('event_price')
            + DB::connection('mysql')->table('payment_sponsors')->where('status', 'paid')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('total_price')
            + DB::connection('mysql_miner')->table('exhibition_payment')->where('status', 'paid')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('total_price')
            + DB::connection('mysql')->table('payment_advertisements')->where('status', 'paid')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('total_price');
    }

    // Mendapatkan pendapatan per kategori dalam periode tertentu untuk chart Pie
    private function getRevenueByCategory($startDate, $endDate)
    {
        return [
            'ticket' => DB::connection('mysql_miner')->table('payment')->where('status', 'Paid Off')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('event_price'),

            'exhibitor' => DB::connection('mysql_miner')->table('exhibition_payment')->where('status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_price'),

            'sponsor' => DB::connection('mysql')->table('payment_sponsors')->where('status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_price'),

            'advertisement' => DB::connection('mysql')->table('payment_advertisements')->where('status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_price')
        ];
    }
    public function getRevenueForCharts()
    {
        // Query untuk mendapatkan total pendapatan berdasarkan kategori dalam satu tahun
        $revenueByCategory = [
            'ticket' => $this->getRevenueForCategory('payment', 'events_tickets_id', 'mysql_miner'),
            'exhibitor' => $this->getRevenueForCategory('exhibition_payment', 'exhibition_id', 'mysql_miner'),
            'sponsor' => $this->getRevenueForCategory('payment_sponsors', 'sponsor_id', 'mysql'),  // MySQL connection
            'advertisement' => $this->getRevenueForCategory('payment_advertisements', 'advertisement_id', 'mysql'),  // MySQL connection
        ];
        return $revenueByCategory;
    }

    // Mendapatkan data pendapatan berdasarkan kategori tertentu dengan database yang disesuaikan
    private function getRevenueForCategory($table, $categoryColumn, $connection)
    {
        // Query untuk mendapatkan total pendapatan dari kategori tertentu selama 1 tahun
        return DB::connection($connection)->table($table)
            ->whereBetween('created_at', [now()->startOfYear(), now()])
            ->sum('total_price');
    }


    // Mendapatkan data pendapatan tahunan per kategori untuk Line Chart (per bulan)
    public function getYearlyRevenueByCategoryForLineChart()
    {
        // Data untuk setiap kategori (Ticket, Exhibitor, Sponsor, Advertisement)
        $categories = ['ticket', 'exhibitor', 'sponsor', 'advertisement'];
        $yearlyRevenueByCategory = [];

        foreach ($categories as $category) {
            $monthlyRevenue = [];
            for ($month = 1; $month <= 12; $month++) {
                // Mengambil total pendapatan per bulan untuk setiap kategori
                $monthlyRevenue[] = $this->getRevenueForCategoryAndMonth($category, $month);
            }
            $yearlyRevenueByCategory[$category] = $monthlyRevenue;
        }

        return $yearlyRevenueByCategory;
    }

    // Mendapatkan total pendapatan untuk kategori dan bulan tertentu
    private function getRevenueForCategoryAndMonth($category, $month)
    {
        $startDate = now()->month($month)->startOfMonth();
        $endDate = now()->month($month)->endOfMonth();

        switch ($category) {
            case 'ticket':
                return DB::connection('mysql_miner')->table('payment')->whereBetween('updated_at', [$startDate, $endDate])->where('status', 'Paid Off')
                    ->sum('event_price');
            case 'advertisement':
                return DB::connection('mysql')->table('payment_advertisements')->where('status', 'paid')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->sum('total_price');
            case 'exhibitor':
                return DB::connection('mysql_miner')->table('exhibition_payment')->where('status', 'paid')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->sum('total_price');
            case 'sponsor':
                return DB::connection('mysql')->table('payment_sponsors')->where('status', 'paid')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->sum('total_price');
            default:
                return 0;
        }
    }

    public function getAllRevenueData()
    {
        // Query untuk Ticket (dari db_miner)
        $ticketRevenues = DB::connection('mysql_miner')->table('payment')->select(
            DB::raw("'Ticket' as category"),
            'code_payment as revenue_id', // Gunakan code_payment
            'event_price as revenue_amount',
            DB::raw('1 as quantity'),
            'created_at',
            'payment_method'
        )
            ->where('status', 'Paid Off')
            ->where('events_id', '13');


        // Query untuk Exhibitor (dari db_miner)
        $exhibitorRevenues = DB::connection('mysql_miner')->table('exhibition_payment')->select(
            DB::raw("'Exhibitor' as category"),
            'code_payment as revenue_id', // Gunakan code_payment
            'total_price as revenue_amount',
            DB::raw('1 as quantity'),
            'invoice_date as created_at'
        )
            ->where('status', 'paid');

        // Query untuk Sponsor (dari db_finance)
        $sponsorRevenues = DB::connection('mysql')->table('payment_sponsors')->select(
            DB::raw("'Sponsor' as category"),
            'code_payment as revenue_id', // Gunakan code_payment
            'total_price as revenue_amount',
            DB::raw('1 as quantity'),
            'invoice_date as created_at'
        )
            ->where('status', 'paid');

        // Query untuk Advertisement (dari db_finance)
        $advertisementRevenues = DB::connection('mysql')->table('payment_advertisements')->select(
            DB::raw("'Advertisement' as category"),
            'code_payment as revenue_id', // Gunakan code_payment
            'total_price as revenue_amount',
            DB::raw('1 as quantity'),
            'invoice_date as created_at'
        )
            ->where('status', 'paid');

        // Gabungkan semua data
        $allData = collect()
            ->merge($ticketRevenues->get())
            ->merge($exhibitorRevenues->get())
            ->merge($sponsorRevenues->get())
            ->merge($advertisementRevenues->get());

        // Urutkan berdasarkan created_at secara descending
        $sortedData = $allData->sortByDesc('created_at');

        // Pagination manual
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $paginatedData = new LengthAwarePaginator(
            $sortedData->forPage($currentPage, $perPage),
            $sortedData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginatedData;
    }


    // Fungsi untuk menghitung persentase perubahan pendapatan
    private function calculatePercentageChange($previousRevenue, $currentRevenue)
    {
        if ($previousRevenue == 0) {
            return 0; // Jika pendapatan sebelumnya 0, tidak ada perubahan
        }

        return (($currentRevenue - $previousRevenue) / $previousRevenue) * 100;
    }
}
