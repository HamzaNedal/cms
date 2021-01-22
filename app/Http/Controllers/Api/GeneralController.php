<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\ShowPostResource;
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

    public function show_post($slug){
        $post = Post::with(['category', 'user', 'media', 'approved_comments'])
        ->active()
        ->post()
        ->whereSlug($slug)
        ->whereHas('category', function ($query) {
            $query->active();
        })
        ->whereHas('user', function ($query) {
            $query->active();
        })
        ->orWhereHas('approved_comments', function ($query) {
            $query->orderBy('created_at','desc');
        })
        ->whereSlug($slug)
        ->first();
        if ($post) {
            return new ShowPostResource($post);
        }
        return response()->json(['error'=>true,'message'=>'No post found',201]);
    }
}
