<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'description',
    ];

    // Vecākkategorija
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Apakškategorijas
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Preces šajā kategorijā
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}