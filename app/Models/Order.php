<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'message',
        'subtotal_cents',
        'fee_cents',
        'total_cents',
        'currency',
        'status',
    ];

    protected $casts = [
        'subtotal_cents' => 'integer',
        'fee_cents' => 'integer',
        'total_cents' => 'integer',
    ];

    /**
     * Get the order items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment for the order.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the message associated with the order.
     */
    public function orderMessage(): HasOne
    {
        return $this->hasOne(Message::class);
    }

    /**
     * Check if order is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if order is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Get formatted total.
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'R$ ' . number_format($this->total_cents / 100, 2, ',', '.');
    }

    /**
     * Generate a unique order code.
     */
    public static function generateCode(): string
    {
        do {
            $code = 'ORD-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->code)) {
                $order->code = self::generateCode();
            }
        });
    }
}
