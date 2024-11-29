<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseDetailsTableSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data detail pengeluaran ke tabel expense_details
        DB::table('expense_details')->insert([
            [
                'expense_id' => 1, // Pastikan sesuai dengan expense_id yang ada di tabel expenses
                'item_name' => 'Printer',
                'quantity' => 2,
                'item_price' => 5000.00,
                'total_price' => 10000.00,
                'payment_proof' => 'path/to/receipt1.jpg', // Bukti pembayaran
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'expense_id' => 1, // Pastikan sesuai dengan expense_id yang ada di tabel expenses
                'item_name' => 'Scanner',
                'quantity' => 1,
                'item_price' => 3000.00,
                'total_price' => 3000.00,
                'payment_proof' => 'path/to/receipt2.jpg', // Bukti pembayaran
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
