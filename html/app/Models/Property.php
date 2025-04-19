<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'for_sale',
        'for_rent',
        'sold',
        'price',
        'currency',
        'currency_symbol',
        'property_type',
        'bedrooms',
        'bathrooms',
        'area',
        'area_type',
        'country',
        'province',
        'street',
        'photo_thumb',
        'photo_search',
        'photo_full',
    ];

    protected $casts = [
        'for_sale' => 'boolean',
        'for_rent' => 'boolean',
        'sold' => 'boolean',
        'price' => 'decimal:2',
        'area' => 'decimal:2',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('sold', false);
    }

    public function scopeForSale($query)
    {
        return $query->where('for_sale', true);
    }

    public function scopeForRent($query)
    {
        return $query->where('for_rent', true);
    }

    public function scopeByProvince($query, $province)
    {
        return $query->where('province', $province);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('province', 'like', "%{$search}%");
        });
    }
}
