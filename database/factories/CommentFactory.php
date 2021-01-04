<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $users = collect(User::where('id','>',2)->get()->modelKeys());
        // $posts = collect(Post::wherePostType('post')->whereStatus(1)->whereCommentAble(1)->get());
        // $id = $posts->random()->id;
        // $created_at = $posts->where('id',$id)->first()->created_at->timestamp;
        // $current_date = Carbon::now()->timestamp;
        // $created_at = date('Y-m-d H:i:s',rand($created_at,$current_date));
        // return [
        //     'name'=>$this->faker->name,
        //     'email'=>$this->faker->email,
        //     'url'=>$this->faker->url,
        //     'ip_address'=>$this->faker->ipv4,
        //     'comment'=>$this->faker->paragraph(2,true),
        //     'status'=>rand(0,1),
        //     'post_id'=>$id,
        //     'user_id'=>$users->random(),
        //     'created_at'=>$created_at,
        //     'updated_at'=>$created_at,
        // ];

        return [
            'name'=>$this->faker->name,
            'email'=>$this->faker->email,
            'url'=>$this->faker->url,
            'ip_address'=>$this->faker->ipv4,
            'comment'=>$this->faker->paragraph(2,true),
            'status'=>rand(0,1),
            // 'post_id'=>$id,
            // 'user_id'=>$users->random(),
            // 'created_at'=>$created_at,
            // 'updated_at'=>$created_at,
        ];
    }
}
