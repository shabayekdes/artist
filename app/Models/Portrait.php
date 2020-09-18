<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portrait extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'featured' => 'boolean',
        'new' => 'boolean',
        'price' => 'float'
    ];

    /**
     * Scope a query to only include feature portraits.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeature($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include feature portraits.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNew($query)
    {
        return $query->where('new', true);
    }

    /**
     * Get the user that owns the portrait.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
