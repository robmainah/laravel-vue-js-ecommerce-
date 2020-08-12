<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Admin;
use App\Customer;
use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $status = $faker->randomElement(['incomplete', 'complete']);
    return [
        'orderId' => $faker->unique()->numberBetween(111111, 999999),
        'customer_id' => function () {
            return Customer::all()->random();
        },
        'comments' => $faker->paragraph,
        'status' => $status,
        'shippingDate' => now(),
        // 'created_by' => rand(1, 10),
        'updated_by' => function () {
            return Admin::all()->random();
        },
    ];
});