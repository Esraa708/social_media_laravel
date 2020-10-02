<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\PostImage;
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

$factory->define(PostImage::class, function (Faker $faker) {
    $image=$faker->image('storage/app/postimages',640, 480, null, false);
    return [
        'image_path' =>  'postimages/'.$image,
        'post_id' => function () {
            return factory(App\Post::class)->create()->id;
        },
    ];
});
