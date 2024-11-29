<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentAdvertisementDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_advertisement_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payment_advertisements')->onDelete('cascade'); // Relasi dengan payment_advertisements
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
