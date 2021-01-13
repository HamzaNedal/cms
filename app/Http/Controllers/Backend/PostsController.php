<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::active()->pluck('name', 'id');
        return view('backend.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->all());
        if ($request->images && count($request->images) > 0) {
            store_image_for_posts($post, $request);
        }
        if ($request->status == 1) {
            Cache::forget('recent_posts');
        }
        return redirect()->route('admin.posts.index')->with([
            'message' => 'Post created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // if (!\auth()->user()->ability('admin', 'display_posts')) {
        //     return redirect('admin/index');
        // }

        $post = Post::with(['media', 'category', 'user', 'comments'])->whereId($id)->wherePostType('post')->first();
        return view('backend.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::whereStatus(1)->pluck('name', 'id');
        return view('backend.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePostRequest $request,Post $post)
    {
        $post->update($request->all());
        
        if ($request->images && count($request->images) > 0) {
            store_image_for_posts($post, $request);
        }

        return redirect()->route('admin.posts.index')->with([
            'message' => 'Post updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if ($post->media->count() > 0) {
            foreach ($post->media as $media) {
                if (File::exists('assets/posts/' . $media->file_name)) {
                    unlink('assets/posts/' . $media->file_name);
                }
            }
        }
        $post->media()->delete();
        $post->delete();

        return redirect()->route('admin.posts.index')->with([
            'message' => 'Post deleted successfully',
            'alert-type' => 'success',
        ]);
    }
    public function destroy_post_media($media_id)
    {
        $media = PostMedia::whereId($media_id)->first();
        $media->delete();
        if (File::exists('assets/posts/' . $media->file_name)) {
            unlink('assets/posts/' . $media->file_name);
            return response()
            ->json(['message' => 'success']);
        }
        return response()
              ->json(['message' => 'failed']);
    }

    public function datatable()
    {
        $posts = Post::query();
        return DataTables::of($posts)
            ->editColumn('title', function ($post) {
                // $post->route = 'posts';
                // return  view('backend.datatables.a_tag')->with(['model' => $post]);
                return "<a href='".route("admin.posts.show",$post->id)."'>$post->title</a>";
            })
            ->editColumn('category', function ($post) {
                return  $post->category->name;
            })
            ->editColumn('user', function ($post) {
                return $post->user->name;
            })
            ->editColumn('comments', function ($post) {
                return $post->comment_able == 1 ? $post->comments->count() : __('Disallow');
            })
            ->editColumn('status', function ($post) {
                return $post->status();
            })
            ->editColumn('created_at', function ($post) {
                return $post->created_at->format('d-m-Y h:i a');
            })
            ->editColumn('actions', function ($post) {
                $post->route = 'posts';
                return view('backend.datatables.actions')->with(['model' => $post]);
            })->startsWithSearch()
            ->rawColumns(['title'])
            ->toJson();
    }
}
