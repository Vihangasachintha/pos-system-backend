<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo; // allows one model to belong to multiple different model types.

class StockMovements extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'reference_type',
        'reference_id',
        'remarks',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // A stock movement can be related to different kinds of records, such as a Purchase, Sale, Return, Adjustment, Transfer, etc.
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}