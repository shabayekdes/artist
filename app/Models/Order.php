<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

        /**
     * Get the user that owns the attributes.
     */
    public function portraits()
    {
        return $this->hasMany(OrderProtrait::class);
    }
}
