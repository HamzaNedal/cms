<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreatePostRequest;
use App\Http\Requests\Frontend\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\Users\UsersCategoryResource;
use App\Http\Resources\Users\UsersPostResource;
use App\Http\Resources\Users\UsersPostsCommentsResource;
use App\Http\Resources\Users\UsersPostsResource;
use App\Http\Resources\Users\UsersTagResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Stevebauman\Purify\Facades\Purify;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }


    public function my_posts()
    {
        return UsersPostsResource::collection(auth()->user()->posts);
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->response_message(false,'Successfully logged out');
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

        return $this->response_message(false,'Post created successfully');

    }

    public function edit_post($id)
    {
        $post =  Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            $tags = Tag::all();
            $categories = Category::active()->get();
            return ['post' => new UsersPostResource($post), 'tags' => UsersTagResource::collection($tags), 'categories' => UsersCategoryResource::collection($categories)];
        }
        return $this->response_message(true,'Unauthrized');
    }

    public function update_post(CreatePostRequest $request, $id)
    {
        $post =  Post::whereId($id)->whereUserId(auth()->id())->first();
        if ($post) {
            $post->update($request->all());
            if (isset($request->images)) {
                if (isset($request->images) && count($request->images) > 0) {
                    store_image_for_posts($post, $request);
                }
            }
            if (isset($request->tags)) {
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
            return $this->response_message(false,'Post Updated successfully');
        }
            return $this->response_message();
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
            return $this->response_message(false,'Post deleted successfully');
        }

        return $this->response_message();
    }

    public function comments()
    {
        $post_ides = auth()->user()->posts()->pluck('id');
        $comments = Comment::whereIn('post_id', $post_ides)->orderBy('created_at', 'desc')->get();

        return UsersPostsCommentsResource::collection($comments);
    }

    public function edit_comment($id)
    {
        $comment = Comment::whereId($id)->whereHas('post', function ($query) {
            $query->where('user_id', auth()->id());
        })->first();
        if ($comment) {
            return new UsersPostsCommentsResource($comment);
        }
        return $this->response_message();
    }
    public function update_comment(UpdateCommentRequest $request, $id)
    {
        $comment = Comment::whereId($id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();
        if ($comment) {

            $request->comment      = Purify::clean($request->comment);
            $comment->update($request->all());
            Cache::forget('recent_comments');
            return $this->response_message(false,'Comment updated successfully');
        }
            return $this->response_message();
    }
    public function destroy_comment($id)
    {
        $comment = Comment::whereId($id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();

        if ($comment) {
            $comment->delete();
            Cache::forget('recent_comments');
            return $this->response_message(false,'Comment deleted successfully');
        } else {
            return $this->response_message();
        }
    }

    public function getNotifications()
    {
        return [
            'read'=>auth()->user()->notifications,
            'unread'=>auth()->user()->unreadNotifications,
        ];
    } 

    public function markAsRead(Request $request)
    {
        return auth()->user()->notifications->where('id',$request->id)->markAsRead();
    }

    public function response_message($error = true,$message='Something was wrong',$status = 200)
    {
        
        return response()->json([
            'errors' => $error,
            'message' => $message,
        ], $status);
    }

   
}
