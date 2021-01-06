<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect(User::where('id', '>', 2)->get()->modelKeys());
        $categories = collect(Category::get()->modelKeys());

        Post::factory()->times(1000)->state(function () use ($users, $categories) {
            $date = Carbon::create(rand(2019, 2020), rand(1, 12), rand(1, 31),rand(0, 23),rand(0, 59),rand(0, 59));
            return [
                'user_id' => $users->random(),
                'category_id' => $categories->random(),
                'created_at' => $date,
                'updated_at' => $date,
            ];
        })->create();
    }
}
