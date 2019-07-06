<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Marca;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$user = null;

$factory->define(Marca::class, function (Faker $faker) use (&$user) {
    if (!$user) $user = factory(User::class)->create();

    return [
        'nome' => Str::random(30),
        'slug' => Str::random(30),
        'user_id' => $user->id,
    ];
});
