<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Page::create([
            "user_id"=> 1,
            "category_id"=> 1,
            "title"=> 'Our vision',
            "description"=> $this->faker->paragraph(),
            "status"=> 1,
            "comment_able"=> 0,
            "post_type"=>'page'
           ]);
        return [
            "user_id"=> 1,
            "category_id"=> 1,
            "title"=> 'About Us',
            "description"=> $this->faker->paragraph(),
            "status"=> 1,
            "comment_able"=> 0,
            "post_type"=>'page'
        ];
    }
}
