<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function get_posts(){
        $posts = Post::whereHas('category', function ($query) {
            $query->active();
        })->whereHas('user', function ($query) {
            $query->active();
        })
        ->post()->active()->descById()->paginate(5);
        if($posts->count() > 0){
            return PostResource::collection($posts);
        }
        return response()->json(['error'=>true,'message'=>'No posts found',201]);
    }
}
