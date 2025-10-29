<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'unit_price_cents',
        'line_total_cents',
    ];

    protected $casts = [
        'qty' => 'integer',
        'unit_price_cents' => 'integer',
        'line_total_cents' => 'integer',
    ];

    /**
     * Get the order that owns the item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get formatted line total.
     */
    public function getFormattedLineTotalAttribute(): string
    {
        return 'R$ ' . number_format($this->line_total_cents / 100, 2, ',', '.');
    }
}
