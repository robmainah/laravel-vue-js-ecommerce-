<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    static $password;
    $regex = "/(\+254|0){1}[7]{1}([0-2]{1}[0-9]{1}|[9]{1}[0-2]{1})[0-9]{6}/";

    return [
        'name' => "Robert Kariuki",
        'userId' => $faker->unique()->numberBetween($min = 111111, $max = 999999),
        'email' => "robmainah@gmail.com",
        'email_verified_at' => now(),
        'phone_number' => "+254703249349",
        'gender' => "Male",
        'idNumber' => rand(11111111, 99999999),
        'dateOfBirth' => now(),
        'password' => $password ?: $password = bcrypt('12345678'),
        'active' => 1,
        'roles' => 3,
        'created_by' => 1,
        // 'created_by' => 1,
        'updated_by' => 1,
        'remember_token' => Null,
    ];
});