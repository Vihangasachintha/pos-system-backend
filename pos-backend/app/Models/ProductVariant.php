<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_id',
        'detail',
    ];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
}