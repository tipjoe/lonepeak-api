<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Connection;
// use App\Notifications\UserRegistered as UserRegisteredNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'first', 'middle', 'last', 'email', 'password', 'phone', 'referral_id', 'location_id'
    // ];
    // This does the same thing, allowing all to be fillable without explicitly listing.

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'datetime:Y-m-d',
        'moved_in' => 'datetime:Y-m-d',
        'moved_out' => 'datetime:Y-m-d'
    ];

    /**
     * Gets all connections, from or to.
     */
    public function connections()
    {
        $from = $this->connectionsFromMe;
        $to = $this->connectionsToMe;
        return $from->merge($to);
    }

    /**
     * Gets the user's connections that they initiated.
     */
    public function connectionsFromMe()
    {
        return $this->belongsToMany(
            User::class,
            'connections',
            'connector_id',
            'connectee_id'
        )
            ->using(Connection::class)
            ->wherePivot('confirmed_at', '!=', null)
            ->whereNull('moved_out')
            ->withTimestamps()
            ->withPivot('connector_id', 'connectee_id', 'confirmed_at');
    }

    /**
     * Gets the user's connections that others initiated.
     */
    public function connectionsToMe()
    {
        return $this->belongsToMany(
            User::class,
            'connections',
            'connectee_id',
            'connector_id'
        )
            ->using(Connection::class)
            ->wherePivot('confirmed_at', '!=', null)
            ->whereNull('moved_out')
            ->withTimestamps()
            ->withPivot('connector_id', 'connectee_id', 'confirmed_at');
    }

    /**
     * Get the gacs for this user.
     */
    public function gacs() {
        return $this->hasMany(Gac::class);
    }

    /**
     * Get the notes for this user.
     */
    public function notes() {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the referrals made by this user.
     */
    public function referrals() {
        return $this->hasMany(Referral::class);
    }

    /**
     * Get the location for this user.
     */
    public function location() {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the user that referred this user.
     */
    public function referrer() {
        return $this->belongsTo(User::class, 'referral_id');
    }

    /**
     * Return the user's full name.
     *
     * @return string
     */
    public function getFullName():string {
        $middle = $this->middle ? $this->middle . " " : "";
        return $this->first . " " . $middle . $this->last;
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    // public function routeNotificationForMail($notification)
    // {
    //     // Return email address and name...
    //     return [$this->email => $this->getFullName()];
    // }

    // public function sendNotification() {
    //     // Twilio expects phone field to be called phone_number.
    //     $this->phone_number = "+1" . $this->phone;
    //     $this->notify(new UserRegisteredNotification());
    // }
}
