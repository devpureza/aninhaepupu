<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'guest_name',
        'content',
        'is_public',
        'approved',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'approved' => 'boolean',
    ];

    /**
     * Get the order that owns the message.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scope for approved messages.
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    /**
     * Scope for public messages.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for messages to display on the wall.
     */
    public function scopeForWall($query)
    {
        return $query->approved()->public()->latest();
    }
}
