<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_sponsors', function (Blueprint $table) {
            $table->id(); // ID field
            $table->timestamps(); // Timestamps for created_at and updated_at
            $table->string('code_payment');
            $table->string('status'); // Status of the payment (e.g., paid, pending)
            $table->decimal('total_price', 15, 2); // Total price of sponsorship
            $table->date('invoice_date'); // Invoice date
            $table->date('invoice_due_date'); // Due date for payment
            $table->string('link'); // Link to invoice or payment details
            $table->decimal('ppn', 15, 2); // Value of tax (PPN)
            $table->string('file_invoice')->nullable(); // Optional field for storing invoice file
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_sponsors');
    }
}
