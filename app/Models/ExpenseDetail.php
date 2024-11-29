<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'item_name',
        'item_price',
        'item_quantity',
        'item_total_price'
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
