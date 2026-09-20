<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'status',
        'ordered_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'ordered_at' => 'datetime',
        ];
    }

    /**
     * Visas preces, kas ietilpst pasūtījumā.
     */
    public function items()
    {
        return $this->hasMany(CustomerOrderItem::class);
    }

    /**
     * Vai pasūtījums vēl gaida izsniegšanu.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Vai pasūtījums jau ir izsniegts.
     */
    public function isIssued(): bool
    {
        return $this->status === 'issued';
    }
}