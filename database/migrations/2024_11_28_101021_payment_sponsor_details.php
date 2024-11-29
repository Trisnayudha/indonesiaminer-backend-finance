<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentSponsorDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_sponsor_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payment_sponsors')->onDelete('cascade'); // Relasi dengan payment_sponsors
            $table->string('description'); // Deskripsi pembayaran
            $table->decimal('amount', 15, 2); // Jumlah pembayaran untuk item detail
            $table->timestamps(); // Untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
