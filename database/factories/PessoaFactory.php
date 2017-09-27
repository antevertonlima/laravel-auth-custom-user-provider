<?php

use Faker\Generator as Faker;

$fakerBr = \Faker\Factory::create('pt_BR');

$factory->define(App\Pessoa::class, function (Faker $faker) use ($fakerBr) {
    return [
        'nome' => $fakerBr->firstName,
        'sobrenome' => $fakerBr->lastName,
        'email' => $faker->unique()->safeEmail,
        'cpf' => $fakerBr->cpf(false)
    ];
});