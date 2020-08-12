<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    static $password;
    $regex = "/(\+254|0){1}[7]{1}([0-2]{1}[0-9]{1}|[9]{1}[0-2]{1})[0-9]{6}/";
    $gender = $faker->randomElement(['Male', 'Female']);
    $active = $faker->randomElement(['1', '0']);

    return [
        'name' => $faker->name($gender),
        'customerId' => $faker->unique()->numberBetween(111111, 999999),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => null,
        'phone_number' => $faker->regexify($regex),
        'idNumber' => rand(1111111, 9999999),
        // 'phone_number' => $faker->phonenumber,
        'address' => $faker->address,
        'gender' => $gender,
        'password' => $password ?: $password = bcrypt('password'),
        'active' => $active,
        'remember_token' => null,
        // 'remember_token' => Str::random(10),
    ];
});