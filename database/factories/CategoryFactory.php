<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {

    return [
        'name' => $faker->sentence(2),
        'slug' => $faker->unique()->slug,
        'description' => $faker->sentence(6),
    ];
});
