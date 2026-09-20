<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'product_id',
        'user_id',
        'quantity',
        'notes',
        'issued_at',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
        ];
    }

    /**
     * Prece, kas tika izsniegta.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Darbinieks, kurš veica izsniegšanu.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}