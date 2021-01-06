<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect(User::where('id', '>', 2)->get()->modelKeys());
        $posts = collect(Post::wherePostType('post')->whereStatus(1)->whereCommentAble(1)->get());
        Comment::factory()->count(5000)->state(function () use ($users, $posts) {
            $id = $posts->random()->id;
            $created_at = $posts->where('id', $id)->first()->created_at->timestamp;
            $current_date = Carbon::now()->timestamp;
            $created_at = date('Y-m-d H:i:s', rand($created_at, $current_date));
            return [
                'post_id' => $id,
                'user_id' => $users->random(),
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ];
        })->create();
    }
}
