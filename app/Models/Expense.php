<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_name',
        'payment_date',
        'base_price',
        'admin_fee',
        'quantity',
        'total',
        'ppn_rate',
        'ppn_amount',
        'payment_type',
        'payment_category',
        'invoice_number',
        'remarks',
        'attachment',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'base_price' => 'integer',
        'admin_fee' => 'integer',
        'quantity' => 'integer',
        'total' => 'integer',
        'ppn_rate' => 'integer',
        'ppn_amount' => 'integer',
    ];

    public function details()
    {
        return $this->hasMany(ExpenseDetail::class);
    }
}
