<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

use Faker\Provider\Lorem;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Post::class, function (Faker $faker) {
    return [
        'post_title' => $faker->name,
        'post_content' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },

    ];
});
