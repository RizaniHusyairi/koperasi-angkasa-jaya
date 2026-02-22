<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'type',
        'partner_name',
        'activity',
        'total_amount',
        'date',
        'status',
        'payment_proof',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
