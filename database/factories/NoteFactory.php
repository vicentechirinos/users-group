<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Note;
use Faker\Generator as Faker;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence(3,true),
        'details'=>$faker->paragraph(3,true),
        'user_id'=>App\User::all()->random()->id,
        'group_id'=>App\Group::all()->random()->id,
    ];
});
