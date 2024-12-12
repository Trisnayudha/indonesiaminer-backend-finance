<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // database/migrations/xxxx_xx_xx_create_invoices_table.php
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('client_name');
            $table->string('client_job_title')->nullable();
            $table->string('client_telephone')->nullable();
            $table->string('client_email');
            $table->string('npwp')->nullable();
            $table->decimal('rate_idr', 15, 2);
            $table->text('client_address');
            $table->enum('payment_method', ['Manual Transfer', 'Xendit Transfer']);
            $table->decimal('total_amount', 15, 2);
            $table->enum('payment_status', ['Unpaid', 'Paid']);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
