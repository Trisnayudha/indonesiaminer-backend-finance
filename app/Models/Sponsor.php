<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;
    protected $connection = 'mysql_miner'; // Koneksi untuk database db_miner

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'sponsors';
}
