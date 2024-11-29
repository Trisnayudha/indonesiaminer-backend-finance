<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_name',
        'total_price',
        'payment_type',
        'expense_category',
        'quantity'
    ];

    public function details()
    {
        return $this->hasMany(ExpenseDetail::class);
    }
}
