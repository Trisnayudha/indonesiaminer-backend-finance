<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpensesTableSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data pengeluaran utama ke tabel expenses
        $expenseId = DB::table('expenses')->insertGetId([
            'expense_name' => 'Event Supplies',
            'code_payment' => 'COS24DF',
            'total_price' => 15000.00,
            'payment_type' => 'Transfer',
            'payment_category' => 'Marketing',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
