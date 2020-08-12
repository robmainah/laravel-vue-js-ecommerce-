<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;

    public function orders()
    {
        return
            $this->belongsToMany('App\Order', 'order_products', 'id')
            ->select('orders.id', 'orders.status', 'comments', 'shippingDate');
    }

    public function products()
    {
        return
            $this->belongsToMany('App\Product', 'order_products', 'id')
            ->select('products.id', 'title', 'image');
    }

    public function getProductAttribute($value)
    {
        return Product::where('id', $value)->first()->title;
    }

    public function getCreatedByAttribute($value)
    {
        return Customer::where('id', $value)->first()['name'];
    }

    public function getUpdatedByAttribute($value)
    {
        return Customer::where('id', $value)->first()['name'];
    }
}