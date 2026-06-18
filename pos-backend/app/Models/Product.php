<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    // These fields are allowed to be mass-assigned (saved from a form/API)
    protected $fillable = [
        'name',
        'description',
        'sku',
        'price',
        'stock',
        'category',
        'is_active',
    ];

    // Cast these fields to their proper types automatically
    protected $casts = [
        'price'     => 'decimal:2',
        'stock'     => 'integer',
        'is_active' => 'boolean',
    ];
}