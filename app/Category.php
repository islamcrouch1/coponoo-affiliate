<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;


class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'image', 'description_ar', 'description_en', 'country_id', 'parent', 'profit'
    ];



    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "%$search%");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
    }


    public function scopeWhenParent($query, $parent)
    {
        return $query->when($parent, function ($q) use ($parent) {
            return $q->where('parent', 'like', "$parent");
        });
    }
}
