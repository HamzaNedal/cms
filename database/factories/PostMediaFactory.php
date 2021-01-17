<?php

namespace Database\Factories;

use App\Models\PostMedia;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostMediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostMedia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = FakerFactory::create();
        return [
            'file_name' => $faker->image('public/assets/posts',640,480, null, false),
            'file_type' => '',
            'file_size' => '',
        ];
    }
}
