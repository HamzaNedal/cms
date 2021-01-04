<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;
   
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $users = collect(User::where('id', '>', 2)->get()->modelKeys());
        // $categories = collect(Category::get()->modelKeys());
        // $date = Carbon::create(rand(2019, 2020), rand(1, 12), rand(1, 31));
        return [
            // "user_id" => $users->random(),
            // "category_id" => $categories->random(),
            "title" => $this->faker->sentence(mt_rand(3, 6), true),
            "description" => $this->faker->paragraph(),
            "status" => rand(0, 1),
            "comment_able" => rand(0, 1),
            // 'created_at' => $date,
            // 'updated_at' => $date,
        ];
    }
}
