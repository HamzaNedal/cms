<?php

namespace App\Http\Livewire\Backend;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class Statistics extends Component
{

    public function render()
    {
        $all_users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->whereStatus(1)->count();
        $active_posts = Post::active()->post()->count();
        $inactive_posts = Post::whereStatus(0)->post()->count();
        $inactive_comments = Comment::whereStatus(0)->count();

        return view('livewire.backend.statistics', [
            "all_users" => $all_users,
            "active_posts" => $active_posts,
            "inactive_posts" => $inactive_posts,
            "inactive_comments" => $inactive_comments,
        ]);
    }
}
