<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAdvertisement extends Model
{
    use HasFactory;

    // Tentukan koneksi untuk model ini
    protected $table = 'payment_advertisement';
    protected $connection = 'mysql'; // Koneksi untuk database db_miner

    // Menambahkan fillable untuk kolom yang boleh diisi
    protected $fillable = [
        'code_payment',
        'status',
        'total_price',
        'invoice_date',
        'invoice_due_date',
        'link',
        'ppn',
        'file_invoice',
    ];
}
