<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'attending',
        'companions',
        'dietary_notes',
    ];

    protected $casts = [
        'attending' => 'boolean',
        'companions' => 'integer',
    ];

    /**
     * Get the guest that owns the RSVP.
     */
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}
