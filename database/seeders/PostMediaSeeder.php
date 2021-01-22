<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Database\Seeder;

class PostMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PostMedia::factory()->create();
        $posts = collect(Post::post()->get());
        PostMedia::factory()->count(100)->state(function () use ( $posts) {
            $post = $posts->random();
            return [
                'post_id' => $post->id,
                'created_at' => $post->created_at,
                'updated_at' => $post->created_at,
            ];
        })->create();
    }
}
