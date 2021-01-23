<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreatePostRequest;
use App\Http\Requests\Frontend\UpdateCommentRequest;
use App\Http\Requests\Frontend\UpdateUserInfoRequest;
use App\Http\Requests\Frontend\UpdateUserPasswordRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function index()
    {
        $posts = auth()->user()->posts()->with(['media', 'category', 'user'])
            ->withCount('approved_comments')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('frontend.users.dashboard', compact('posts'));
    }
    public function edit_info()
    {
        return view('frontend.users.edit_info');
    }
    public function update_info(UpdateUserInfoRequest $request)
    {


        if ($image = $request->file('user_image')) {
            if (auth()->user()->user_image != ''){
                if (File::exists('/assets/users/' . auth()->user()->user_image)){
                    unlink('/assets/users/' . auth()->user()->user_image);
                }
            }
            $filename = Str::slug(auth()->user()->username).'.'.$image->getClientOriginalExtension();
            $path = public_path('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $data['user_image'] = $filename;
        }

        $update = auth()->user()->update($request->all());

        if ($update) {
            return redirect()->back()->with([
                'message' => 'Information updated successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function update_password(UpdateUserPasswordRequest $request)
    {

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $update = $user->update([
                'password' => $request->password,
            ]);

            if ($update) {
                return redirect()->back()->with([
                    'message' => 'Password updated successfully',
                    'alert-type' => 'success',
                ]);
            } else {
                return redirect()->back()->with([
                    'message' => 'Something was wrong',
                    'alert-type' => 'danger',
                ]);
            }

        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function create_post()
    {
        $categories = Category::whereStatus(1)->pluck('name', 'id');
        return view('frontend.users.create_post', compact('categories'));
    }
    public function store_post(CreatePostRequest $request)
    {
        // dd($request->all();
        $post = auth()->user()->posts()->create($request->all());
        if ($request->images && count($request->images) > 0) {
            store_image_for_posts($post, $request);
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

        if ($post) {
            $categories = Category::whereStatus(1)->pluck('name', 'id');
            return view('frontend.users.edit_post', compact('post', 'categories'));
        }
        return redirect()->route('home');
    }
    public function update_post(Post $post, CreatePostRequest $request)
    {

        $post =  $post->whereId($post->id)->whereUserId(auth()->id())->first();
        if ($post) {
            $post->update($request->all());
            if ($request->images && count($request->images) > 0) {
                store_image_for_posts($post, $request);
            }
            return redirect()->back()->with([
                'message' => 'Post updated successfully',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }
    public function destroy_post(Post $post)
    {
        $post =  $post->whereId($post->id)->whereUserId(auth()->id())->first();

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

            return redirect()->back()->with([
                'message' => 'Post deleted successfully',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }
    public function destroy_post_media($media_id)
    {
        $media = PostMedia::whereId($media_id)->first();
        $media->delete();
        if (File::exists('asset/posts/' . $media->file_name)) {
            unlink('asset/posts/' . $media->file_name);
        }
    }
    public function show_comments()
    {
        $post_ides = auth()->user()->posts()->pluck('id');
        $comments = Comment::whereIn('post_id', $post_ides)->orderBy('created_at', 'desc')->paginate();
        // dd($comments);
        return view('frontend.users.comments', compact('comments'));
    }
    public function edit_comment($comment_id)
    {
        $comment = Comment::whereId($comment_id)->whereHas('post')->first();
        if ($comment) {
            return view('frontend.users.edit_comment', compact('comment'));
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }
    public function update_comment(UpdateCommentRequest $request, $comment_id)
    {

        $comment = Comment::whereId($comment_id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();
        if ($comment) {

            $request->comment      = Purify::clean($request->comment);
            $comment->update($request->all());

            if ($request->status == 1) {
                Cache::forget('recent_comments');
            }

            return redirect()->back()->with([
                'message' => 'Comment updated successfully',
                'alert-type' => 'success',
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }
    public function destroy_comment($comment_id)
    {
        $comment = Comment::whereId($comment_id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();

        if ($comment) {
            $comment->delete();

            Cache::forget('recent_comments');

            return redirect()->back()->with([
                'message' => 'Comment deleted successfully',
                'alert-type' => 'success',
            ]);

        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }
}