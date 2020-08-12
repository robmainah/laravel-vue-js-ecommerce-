<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $appends = ['last_updated'];

    public function product()
    {
        return $this->hasMany('App\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function getUpdatedByAttribute($value)
    {
        return User::where('id', $value)->first()['name'];
    }

    public function getLastUpdatedAttribute()
    {
        return $this->updated_at->isoFormat("MMM Do YYYY");
    }

    // public function getCategoryNameAttribute($value)
    // {
    //     return strtoupper($value);
    //     // $cat_name = Category::where('category_name', $value)->pluck('category_name');
    //     // return $cat_name;
    // }
}