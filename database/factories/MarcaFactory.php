<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Marca;
use App\User;
use Faker\Generator as Faker;

$user = null;

$factory->define(Marca::class, function (Faker $faker) use (&$user) {
    if (!$user) $user = factory(User::class)->create();

    return [
        'nome' => $faker->realText(30),
        'slug' => $faker->unique()->realText(30),
        'user_id' => $user->id,
    ];
});
