<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'password', 'otp', 'rating', 'email_verified_at', 'avatar', 'fcm_token'
    ];

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
    ];

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\User
     */
    public function findForPassport($phone)
    {
        return $this->where('phone', $phone)->first();
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function portraits()
    {
        return $this->hasMany(Portrait::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }


    /**
     * The portraits that belong to the user.
     */
    public function fav()
    {
        return $this->belongsToMany(Portrait::class, 'favorites', 'user_id', 'portrait_id');
    }
}
