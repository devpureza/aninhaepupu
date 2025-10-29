<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'household_id',
        'invite_code',
        'rsvp_status',
        'companions_allowed',
        'companions_confirmed',
        'notes',
    ];

    protected $casts = [
        'companions_allowed' => 'integer',
        'companions_confirmed' => 'integer',
    ];

    /**
     * Get the RSVP for the guest.
     */
    public function rsvp(): HasOne
    {
        return $this->hasOne(Rsvp::class);
    }

    /**
     * Get all guests in the same household.
     */
    public function householdMembers(): HasMany
    {
        return $this->hasMany(Guest::class, 'household_id', 'household_id')
            ->where('id', '!=', $this->id);
    }

    /**
     * Check if guest has confirmed attendance.
     */
    public function hasConfirmed(): bool
    {
        return $this->rsvp_status === 'confirmed';
    }

    /**
     * Generate a unique invite code.
     */
    public static function generateInviteCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        } while (self::where('invite_code', $code)->exists());

        return $code;
    }
}
