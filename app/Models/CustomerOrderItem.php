<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_order_id',
        'product_id',
        'quantity',
    ];

    /**
     * Pasūtījums, kuram pieder šī rinda.
     */
    public function customerOrder()
    {
        return $this->belongsTo(CustomerOrder::class);
    }

    /**
     * Pasūtītā prece.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}