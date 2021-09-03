<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartPortrait extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function portraitAttributes()
    {
        return $this->belongsToMany(PortraitAttribute::class, 'cart_portrait_attributes')->as('attributes');
    }

    public function portrait()
    {
        return $this->belongsTo(Portrait::class);
    }
}
