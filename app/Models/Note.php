<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * @TODO add an incrementing PK.
     */
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'location_id', 'note'
    ];

    /**
     * Get the user for this note.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the location for this note.
     */
    public function location() {
        return $this->belongsTo('App\Location');
    }
}
