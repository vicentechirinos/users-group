<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name'=>$faker->sentence(3,true),
        'user_id'=>App\User::all()->random()->id,
    ];
});
