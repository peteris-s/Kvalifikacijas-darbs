<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'type',
        'description',
    ];

    public function parent()
    {
        return $this->belongsTo(
            WarehouseLocation::class,
            'parent_id'
        );
    }

    public function children()
    {
        return $this->hasMany(
            WarehouseLocation::class,
            'parent_id'
        );
    }
}