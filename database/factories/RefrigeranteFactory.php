<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Marca;
use App\Refrigerante;
use Faker\Generator as Faker;

$marca = null;

$factory->define(Refrigerante::class, function (Faker $faker) use (&$marca) {
    if (!$marca) $marca = factory(Marca::class)->create();

    return [
        'marca_id' => $marca->id,
        'litragem' => $faker->randomFloat(null, 0, 3),
        'tipo' => 'Pet',
        'quantidade' => $faker->numberBetween(0, 300),
        'valor_unitario' => $faker->randomFloat(null, 0, 15),
    ];
});
