<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    
    public function index()
    {
        $posts = auth()->user()->posts()->with(['media','category','user'])
        ->withCount('approved_comments')
        ->orderBy('id','desc')
        ->paginate(10); 
        return view('frontend.users.dashboard',compact('posts'));
    }

    public function create_post()
    {
        $categories = Category::whereStatus(1)->pluck('name','id');
       return view('frontend.users.create_post',compact('categories'));
    }

    public function store_post(CreatePostRequest $request)
    {
        // dd($request->all();
        $post = auth()->user()->posts()->create($request->all());
        if($request->images && count($request->images) > 0){
            store_image_for_posts($post,$request);
        }
        if ($request->status == 1) {
            Cache::forget('recent_posts');
        }

        return redirect()->back()->with([
            'message' => 'Post created successfully',
            'alert-type' => 'success',
        ]);
    }
    public function edit_post(Post $post)
    {
        $post =  $post->whereId($post->id)->whereUserId(auth()->id())->first();
 
        if($post){
            $categories = Category::whereStatus(1)->pluck('name','id');
            return view('frontend.users.edit_post',compact('post','categories'));
        }
        return redirect()->route('home');
    }
    public function update_post()
    {
        
    }

}
