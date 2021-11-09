<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "price" => $faker->randomFloat(2, 0, 8),               //num de casas decimais, minimo e maximo;
        "description" => $faker->text
    ];
});
