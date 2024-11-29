<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSponsor extends Model
{
    use HasFactory;


    // Nama tabel yang digunakan oleh model ini
    protected $table = 'payment_sponsors';
    protected $connection = 'mysql'; // Koneksi untuk database db_miner

    // Nama primary key tabel (default 'id', bisa disesuaikan)
    protected $primaryKey = 'id';

    // Tentukan apakah primary key adalah auto-increment (default true)
    public $incrementing = true;

    // Tentukan tipe data primary key (integer, string, dll)
    protected $keyType = 'int';

    // Tentukan field yang bisa diisi (mass-assignment)
    protected $fillable = [
        'created_at',
        'updated_at',
        'code_payment',
        'status',
        'total_price',
        'invoice_date',
        'invoice_due_date',
        'link',
        'ppn',
        'file_invoice'
    ];

    // Tentukan field yang tidak boleh diisi (protected)
    protected $guarded = ['id'];

    // Tentukan format timestamp jika menggunakan format lain selain default (Y-m-d H:i:s)
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Tentukan tipe kolom tanggal
    protected $dates = ['created_at', 'updated_at', 'invoice_date', 'invoice_due_date'];

    // Relasi ke tabel lain (jika ada)
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id'); // Relasi ke model Sponsor
    }

    // Contoh method untuk mendapatkan total tagihan setelah PPN
    public function getTotalWithPPN()
    {
        return $this->total_price + ($this->total_price * $this->ppn / 100);
    }
}
