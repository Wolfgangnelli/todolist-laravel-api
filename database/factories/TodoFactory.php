<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Todo;
use Faker\Generator as Faker;
//ogni volta che chiamerò questa factory ritornerò un array di dati per popolare i record della tabella nel DB
//variabile globale $factory, si definisce il nome della factory(il nome del model di riferimento) e poi una funz che verrà eseguita ogni volta che chiamerò 
//factory create di questa factory
$factory->define(Todo::class, function (Faker $faker) {
    return [
        //dati da ritornare
        'todo' => $faker->sentence(6),
        'completed' => $faker->randomElement([0,1]),
    ];
});



