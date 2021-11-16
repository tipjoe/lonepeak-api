<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'location_id', 'expires', 'hash'
    ];

    /**
     * Get the user who made this referral.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the location for this referral.
     */
    public function location() {
        return $this->belongsTo(Location::class);
    }
}
