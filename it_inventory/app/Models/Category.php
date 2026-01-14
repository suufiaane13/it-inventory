<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    /**
     * Get equipments in this category
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
