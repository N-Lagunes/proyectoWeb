<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {

	$title = $faker->unique()->word(5);

    return [
        'name' => $title,
        'slug' => str_slug($title)
    ];
});