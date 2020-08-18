<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user that owns the portrait.
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, "from_user");
    }

    /**
     * Get the user that owns the portrait.
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, "to_user");
    }
}
