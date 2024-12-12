<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'client_name',
        'client_job_title',
        'client_telephone',
        'client_email',
        'npwp',
        'rate_idr',
        'client_address',
        'payment_method',
        'total_amount',
        'ppn_rate',
        'ppn_amount',
        'payment_status',
        'notes',
        'company_name'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'rate_idr' => 'integer',
        'total_amount' => 'integer',
        'ppn_rate' => 'integer',
        'ppn_amount' => 'integer',
    ];
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
