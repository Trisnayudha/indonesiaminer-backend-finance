<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\ExpenseDetail;
use Carbon\Carbon;

class PengeluaranService
{
    public function getAll()
    {
        return Expense::orderby('id', 'desc')->paginate(10);
    }
    // Get Weekly Revenue
    public function getWeeklyRevenue()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Filter expenses created within the week
        $weeklyExpenses = Expense::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('total_price');

        return $weeklyExpenses;
    }

    // Get Monthly Revenue
    public function getMonthlyRevenue()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Filter expenses created within the month
        $monthlyExpenses = Expense::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_price');

        return $monthlyExpenses;
    }

    // Get Yearly Revenue
    public function getYearlyRevenue()
    {
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        // Filter expenses created within the year
        $yearlyExpenses = Expense::whereBetween('created_at', [$startOfYear, $endOfYear])
            ->sum('total_price');

        return $yearlyExpenses;
    }

    // Get data for Bar Chart (Expenses by Category and Venue)
    public function getExpenseBarChartData()
    {
        // Data grouped by category (Marketing, Operational, etc.)
        $expensesByCategory = Expense::select('payment_category', Expense::raw('SUM(total_price) as total_expenses'))
            ->groupBy('payment_category')
            ->get();

        // Prepare data for bar chart
        $categories = $expensesByCategory->pluck('payment_category');
        $totals = $expensesByCategory->pluck('total_expenses');

        return [
            'categories' => $categories,
            'totals' => $totals,
        ];
    }

    // Get data for Pie Chart (Expense Percentage by Category)
    public function getExpensePieChartData()
    {
        // Calculate total expenses grouped by category
        $expensesByCategory = Expense::select('payment_category', Expense::raw('SUM(total_price) as total_expenses'))
            ->groupBy('payment_category')
            ->get();

        // Prepare data for pie chart
        $labels = $expensesByCategory->pluck('payment_category');
        $data = $expensesByCategory->pluck('total_expenses');
        $backgroundColors = ['#17a2b8', '#007bff', '#28a745']; // Customize for each category

        return [
            'labels' => $labels,
            'data' => $data,
            'backgroundColors' => $backgroundColors,
        ];
    }
}
