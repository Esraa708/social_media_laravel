<?php

use Illuminate\Database\Seeder;

class PostImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PostImage::class, 5)->create();
    }
}
