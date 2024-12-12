<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExpensesTableAddFields extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_name'); // Nama Pengeluaran
            $table->date('payment_date'); // Payment Date
            $table->integer('base_price'); // Harga Pokok
            $table->integer('admin_fee')->nullable(); // Fee Admin (Optional)
            $table->integer('quantity');
            $table->integer('total');
            $table->string('payment_type'); // Payment Type
            $table->string('payment_category');
            $table->string('invoice_number')->unique();
            $table->text('remarks')->nullable(); // Remarks
            $table->string('attachment')->nullable();
            $table->integer('ppn_rate')->default(0); // PPN (%) - Default 0 (tidak ada)
            $table->integer('ppn_amount')->default(0); // PPN Amount (IDR) - Default 0
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
