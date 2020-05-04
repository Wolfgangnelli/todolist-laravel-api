<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TodoList;
use Faker\Generator as Faker;

$factory->define(TodoList::class, function (Faker $faker) {
    return [
        'name' => $faker->name 
    ];
});
//avrei anche user_id come campo obligatorio ma glielo passo nel seeder dello user