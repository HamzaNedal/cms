<?php

namespace App\Http\Livewire\Backend;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class LastPostComments extends Component
{
    public function render()
    {
        $posts = Post::post()->withCount('comments')->orderBy('created_at','desc')->take(5)->get();
        $comments = Comment::orderBy('created_at','desc')->take(5)->get();
        return view('livewire.backend.last-post-comments',[
            "posts"=>$posts,
            "comments"=>$comments,
        ]);
    }
}