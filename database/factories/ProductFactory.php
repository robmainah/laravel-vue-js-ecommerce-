<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Admin;
use App\Category;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $title = $faker->word;

    return [
        'productId' => $faker->unique()->numberBetween(111111, 999999),
        'category_id' => function () {
            return Category::all()->random();
        },
        'title' => $title,
        'slug' => str_slug($title),
        'description' => $faker->paragraph,
        'price' => rand(111, 510),
        'quantity' => $faker->randomDigit,
        'image' => "images/546819.jpeg",
        'created_by' => function () {
            return Admin::all()->random();
        },
        'updated_by' => function () {
            return Admin::all()->random();
        },
    ];
});