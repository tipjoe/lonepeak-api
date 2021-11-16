<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Keep track of gacs (give-a-crap - aka when someone cares).
 */
class Gac extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'location_id'
    ];

    /**
     * Get the user for this gac.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the location for this gac.
     */
    public function location() {
        return $this->belongsTo(Location::class);
    }
}
