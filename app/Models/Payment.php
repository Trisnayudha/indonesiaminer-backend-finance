<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Tentukan koneksi yang digunakan untuk model ini
    protected $connection = 'mysql_miner'; // Koneksi untuk database db_miner

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'payment';

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
        'type',
        'code_payment',
        'users_id',
        'events_id',
        'package_id',
        'package',
        'payment_voucher_id',
        'voucher_code',
        'voucher_value',
        'payment_method',
        'event_price',
        'event_price_dollar',
        'voucher_price',
        'voucher_price_dollar',
        'total_price',
        'total_price_dollar',
        'status',
        'aproval_quota_users',
        'curs_dollar',
        'company_id',
        'package_company_detail_id',
        'expired_date',
        'package_company_id',
        'events_tickets_id',
        'events_tickets_title',
        'events_tickets_type',
        'qr_code',
        'booking_id',
        'pic',
        'trash',
        'link_reference',
        'rate_idr'
    ];

    // Tentukan field yang tidak boleh diisi (protected)
    protected $guarded = ['id'];

    // Tentukan format timestamp jika menggunakan format lain selain default (Y-m-d H:i:s)
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Tentukan tipe kolom tanggal
    protected $dates = ['created_at', 'updated_at', 'expired_date'];

    // Relasi ke tabel lain (jika ada)
    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id');
    }

    // Contoh method lain untuk business logic jika diperlukan
    public function calculateTotalAmount()
    {
        return $this->total_price - $this->voucher_value;
    }
}
