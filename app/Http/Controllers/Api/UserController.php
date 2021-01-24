<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\Users\UsersCategoryResource;
use App\Http\Resources\Users\UsersPostResource;
use App\Http\Resources\Users\UsersPostsResource;
use App\Http\Resources\Users\UsersTagResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function my_posts()
    {
        return UsersPostsResource::collection(auth()->user()->posts);
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['error' => false, 'message' => 'Successfully logged out'], 200);
    }

    public function create()
    {
        $tags = Tag::all();
        $categories = Category::active()->get();
        return ['tags' => UsersTagResource::collection($tags), 'categories' => UsersCategoryResource::collection($categories)];
    }

    public function store_post(CreatePostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->all());
        if ($request->images && count($request->images) > 0) {
            store_image_for_posts($post, $request);
        }

        if (count($request->tags) > 0) {
            $new_tags = [];

            foreach ($request->tags as  $tag) {
                $tag = Tag::firstOrCreate([
                    'id' => $tag
                ], [
                    'name' => $tag
                ]);
                $new_tags[] = $tag->id;
            }

            $post->tags()->sync($new_tags);
        }

        if ($request->status == 1) {
            Cache::forget('recent_posts');
        }

        return response()->json([
            'errors' => false,
            'message' => 'Post created successfully',
        ], 200);
    }

    public function edit_post($id)
    {
        $post =  Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            $tags = Tag::all();
            $categories = Category::active()->get();
            return ['post' => new UsersPostResource($post), 'tags' => UsersTagResource::collection($tags), 'categories' => UsersCategoryResource::collection($categories)];
        }
        return response()->json(['error' => true, 'message' => 'Unauthrized'], 200);
    }

    public function update_post(CreatePostRequest $request,$id)
    {
        $post =  Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            $post->update($request->all());
            if(isset($request->images)){
                if (isset($request->images) && count($request->images) > 0) {
                    store_image_for_posts($post, $request);
                }
            }
            if(isset($request->tags)){
                if (count($request->tags) > 0) {
                    $new_tags = [];
                    foreach ($request->tags as  $tag) {
                        $tag = Tag::firstOrCreate([
                            'id' => $tag
                        ], [
                            'name' => $tag
                        ]);
                        $new_tags[] = $tag->id;
                    }
                    $post->tags()->sync($new_tags);
                }
             }
            Cache::forget('recent_posts');
            return response()->json([
                'errors' => false,
                'message' => 'Post Updated successfully',
            ], 200);
        }

        return response()->json([
            'errors' => true,
            'message' => 'Something was wrong',
        ], 200);
    }
    public function destroy_post($id)
    {
        $post = Post::whereId($id)->whereUserId(auth()->id())->first();

        if ($post) {
            if ($post->media->count() > 0) {
                foreach ($post->media as $media) {
                    if (File::exists('assets/posts/' . $media->file_name)) {
                        unlink('assets/posts/' . $media->file_name);
                    }
                }
            }
            $post->media()->delete();
            $post->delete();

            return response()->json([
                'errors' => false,
                'message' => 'Post deleted successfully',
            ], 200);
        }

        return response()->json([
            'errors' => true,
            'message' => 'Something was wrong',
        ], 200);
    }
}
