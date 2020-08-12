<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Admin;
use App\Order;
use App\OrderProduct;
use App\Product;
use Faker\Generator as Faker;

$factory->define(OrderProduct::class, function (Faker $faker) {
    return [
        'order_id' => function () {
            return Order::all()->random();
        },
        'product_id' => function () {
            return Product::all()->random();
        },
        'lineItemsNo' => rand(1, 5),
        'priceEach' => rand(121, 7679),
        'quantity' => $faker->randomDigit,
        'status' => $faker->randomElement(['incomplete', 'complete']),
        // 'created_by' => rand(1, 10),
        'updated_by' => function () {
            return Admin::all()->random();
        },
    ];
});