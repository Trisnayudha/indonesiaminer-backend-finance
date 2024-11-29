<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('code_payment'); // Nama pengeluaran
            $table->string('expense_name'); // Nama pengeluaran
            $table->decimal('total_price', 15, 2); // Total harga
            $table->string('payment_type'); // Jenis pembayaran (Cash/Transfer)
            $table->string('payment_category'); // Kategori pembayaran (Marketing/Operational/Salary)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
