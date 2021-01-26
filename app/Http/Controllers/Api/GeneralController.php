<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreateCommentRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\ShowPostResource;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\NewCommentForAdminNotify;
use App\Notifications\NewCommentForPostOwnerNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{
    public function get_posts()
    {
        $posts = Post::whereHas('category', function ($query) {
            $query->active();
        })->whereHas('user', function ($query) {
            $query->active();
        })
            ->post()->active()->descById()->paginate(5);
        if ($posts->count() > 0) {
            return PostResource::collection($posts);
        }
        return response()->json(['error' => true, 'message' => 'No posts found', 201]);
    }

    public function show_post($slug)
    {
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
                $query->orderBy('created_at', 'desc');
            })
            ->whereSlug($slug)
            ->first();
        if ($post) {
            return new ShowPostResource($post);
        }
        return response()->json(['error' => true, 'message' => 'No post found', 201]);
    }

    public function search(Request $request)
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;

        $posts = Post::with(['media', 'user'])
            ->whereHas('category', function ($query) {
                $query->active();
            })
            ->whereHas('user', function ($query) {
                $query->active();
            })->orderBy('created_at', 'desc');

        if ($keyword != null) {
            $posts = $posts->search($keyword, null, true);
        }
        $posts = $posts->post()->active()->orderBy('id', 'desc')->paginate(5);
        if (count($posts) > 0) {
            return  ShowPostResource::collection($posts);
        }
        return response()->json(['error' => true, 'message' => 'No posts found', 200]);
    }
    public function category($slug)
    {
        $category = Category::whereSlug($slug)->first();
        if ($category && $category->status == 1) {
            $posts = Post::with(['media', 'user'])
                ->whereCategoryId($category->id)
                ->post()
                ->active()
                ->descById()
                ->paginate(5);

            if (count($posts) > 0) {
                return  ShowPostResource::collection($posts);
            }
            return response()->json(['error' => true, 'message' => 'No posts found', 200]);
        }

        return response()->json(['error' => true, 'message' => 'No Category found', 200]);
    }

    public function tag($slug)
    {
        $tag = Tag::whereSlug($slug)->first();
        if ($tag) {
            $tag_id = $tag->id;
            $posts = Post::with(['media', 'user', 'tags'])
                ->whereHas('tags', function ($query) use ($tag_id) {
                    $query->where('id', $tag_id);
                })
                ->post()
                ->active()
                ->descById()
                ->paginate(5);

            if (count($posts) > 0) {
                return  ShowPostResource::collection($posts);
            }
            return response()->json(['error' => true, 'message' => 'No posts found', 200]);
        }

        return response()->json(['error' => true, 'message' => 'No Tag found', 200]);
    }

    public function author($username)
    {
        $user = User::where('username', $username)->first();
        if ($user && $user->status == 1) {
            $posts = Post::with(['media', 'user', 'user'])
                ->withCount('approved_comments')
                ->whereUserId($user->id)
                ->post()
                ->active()
                ->descById()
                ->paginate(5);

            if (count($posts) > 0) {
                return  ShowPostResource::collection($posts);
            }
            return response()->json(['error' => true, 'message' => 'No posts found', 200]);
        }

        return response()->json(['error' => true, 'message' => 'No User found', 200]);
    }
    public function store_comment(CreateCommentRequest $request, $slug)
    {
        $post = Post::where('slug',$slug)->post()->active()->first();
        if ($post) {
            $request['post_id']        = $post->id;
            $comment = $post->comments()->create($request->all());
            if (auth()->guest() || auth()->id() != $post->user_id && auth()->user()->hasRole(['editor', 'admin'])) {
                $post->user->notify(new NewCommentForPostOwnerNotify($comment));
            }
            User::whereHas('roles',function($query){
                $query->whereIn('name',['admin','editor']);
            })->each(function($admin,$key) use ($comment){
                $admin->notify(new NewCommentForAdminNotify($comment));
            });
            return response()->json(['error' => false, 'message' => 'Comment added successfully', 200]);
        }
        return response()->json(['error' => true, 'message' => 'Something was wrong', 200]);
    }


    public function store_contact_us(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'mobile'    => 'nullable|numeric',
            'title'     => 'required|min:5',
            'message'   => 'required|min:10',
        ]);
        if ($validation->fails()){
            return response()->json(['errors'=>true,'message'=>$validation->errors()],200);
        }

        $data['name']       = $request->name;
        $data['email']      = $request->email;
        $data['mobile']     = $request->mobile;
        $data['title']      = $request->title;
        $data['message']    = $request->message;

        Contact::create($data);
        return response()->json(['error' => false, 'message' => 'Message sent successfully', 200]);
    }
}
