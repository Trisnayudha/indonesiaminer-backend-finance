<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Migration untuk tabel expense_details
        Schema::create('expense_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained('expenses')->onDelete('cascade'); // Relasi ke pengeluaran utama
            $table->string('item_name'); // Nama barang (printer, scanner, dll.)
            $table->integer('quantity'); // Jumlah barang
            $table->decimal('item_price', 15, 2); // Harga per barang
            $table->decimal('total_price', 15, 2); // Total harga item
            $table->string('payment_proof'); // Bukti pembayaran (misal URL gambar)
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
        Schema::dropIfExists('expense_details');
    }
}
