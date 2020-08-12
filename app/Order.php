<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use DB;

class Order extends Model
{
    use SoftDeletes;

    public function products()
    {
        return $this->belongsToMany('App\Product', 'order_products');
    }

    public function orderProducts()
    {
        // $totals = DB::raw('order_products.priceEach * order_products.quantity as totals');
        return $this->hasMany('App\OrderProduct')
            ->select(
                'id',
                'order_id',
                'product_id AS product',
                'priceEach',
                'quantity',
                // DB::raw('order_products.priceEach * order_products.quantity as totals'),
                'updated_at'
            );
    }

    //create a method to generate Order Number
    public function scopeGenerateOrderNumber($query)
    {
        $random_id = "OR" . rand(111111, 999999);
        $value = $query->where('orderId', $random_id)->get();
        // $value = count($value);
        if (count($value) > 0) {
            return Self::generateOrderNumber();
        }

        return $random_id;
    }

    public function scopeGetOrderId($query, $val = null)
    {
        $value = $query->where('orderId', $val)->first();

        return $value->id;
    }
}