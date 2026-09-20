<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'product_id',
        'user_id',
        'quantity',
        'received_at',
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];

    public function document()
    {
        return $this->belongsTo(StockReceiptDocument::class, 'document_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}