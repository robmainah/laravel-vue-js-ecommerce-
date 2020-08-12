<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    // protected $dates = ['updated_at'];
    // protected $appends = ['last_updated'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order', 'order_products');
    }

    public function orderProducts()
    {
        return $this->hasMany('App\OrderProduct');
    }

    public function setTitleAttribute($value)
    {
        return $this->attributes['title'] = trim(ucwords($value));
    }

    public function getCategoryIdAttribute($value)
    {
        return Category::where('id', $value)->first()['category_name'];
    }

    public function getCreatedByAttribute($value)
    {
        return User::where('id', $value)->first()['name'];
    }

    public function getUpdatedByAttribute($value)
    {
        return User::where('id', $value)->first()['name'];
    }

    // public function getLastUpdatedAttribute()
    // {
    //     return $this->updated_at->isoFormat("MMM Do YYYY");
    // }

    public function scopeGenerateProductNumber($query)
    {
        $random_id = rand(111111, 999999);
        $value = $query->where('productId', $random_id)->get();
        // $value = count($value);
        if (count($value) > 0) {
            return Self::generateProductNumber();
        }

        return $random_id;
    }
}