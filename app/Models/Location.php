<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address1', 'address2', 'parcel', 'city', 'state', 'zip', 'latitude', 'longitude', 'geometry'
    ];

    /**
     * Get the users for this location.
     */
    public function users() {
        return $this->hasMany(User::class);
    }

    /**
     * Get give-a-craps (gacs) for this location.
     */
    public function gacs() {
        return $this->hasMany(Gac::class);
    }

    /**
     * Get the neighbors (closest 10 distances) for this location.
     * In distance table, 'from' is this location and 'to' is other locations.
     */
    public function distances() {
        return $this->hasMany(Distance::class, 'from');
    }
}
