<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Portrait;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Portrait::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        // 'sku' => Str::random(40),
        // 'slug' => $faker->unique()->slug,
        'price' => $faker->numberBetween(100, 1000),
        'category_id' => $faker->numberBetween(1, 5),
        'user_id' => $faker->numberBetween(1, 10),
        'featured' => $faker->boolean(),
        'new' => $faker->boolean(),
        'thumbnail' => 'images/img-placeholder.png'
    ];
});
