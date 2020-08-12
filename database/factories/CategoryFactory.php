<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Admin;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $cat = ['Computers', 'Mobiles', 'Printers', 'Networks', 'Softwares'];

    return [
        'categoryId' => $faker->unique()->numberBetween(111111, 999999),
        'category_name' => $faker->randomElement($cat),
        'created_by' => function () {
            return Admin::all()->random();
        },
        'updated_by' => function () {
            return Admin::all()->random();
        },
        'activated' => $faker->randomElement(['Yes', 'No']),
    ];
});