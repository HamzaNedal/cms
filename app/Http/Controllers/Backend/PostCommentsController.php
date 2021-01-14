<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdatePostCommentsRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->ability('admin','manage_post_comments,show_post_comments')) {
            return abort(403);
        }
        return view('backend.post_comments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $post_comment)
    {
        if (!auth()->user()->ability('admin','update_post_comments')) {
            return abort(403);
        }
        return view('backend.post_comments.edit', compact('post_comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostCommentsRequest $request, Comment $post_comment)
    {
        $post_comment->update($request->all());
        Cache::forget('recent_comments');
        return redirect()->route('admin.post_comments.index')->with([
            'message' => 'Comment updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $post_comment)
    {
        if (!auth()->user()->ability('admin','delete_post_comments')) {
            return abort(403);
        }
        $post_comment->delete();
        return redirect()->route('admin.post_comments.index')->with([
            'message' => 'Comment deleted successfully',
            'alert-type' => 'success',
        ]);
    }
    public function datatable()
    {
        if (!auth()->user()->ability('admin','manage_post_comments,show_post_comments')) {
            return abort(403);
        }
        $post_comments = Comment::query();
        return DataTables::of($post_comments)
        ->addColumn('image', function ($comment) {
            return "<img src='".get_gravatar($comment->email,50)."' class='img-circle'>";
        })
        ->addColumn('post', function ($comment) {
            return "<a href='".route("admin.posts.show",$comment->post_id)."'>".$comment->post->title." </a>";
        })
        ->editColumn('actions', function ($post_comments) {
            $post_comments->route = 'post_comments';
            return view('backend.datatables.actions')->with(['model' => $post_comments]);
        })
        ->editColumn('status', function ($post_comments) {
            return $post_comments->status();
        })
        ->editColumn('created_at', function ($post_comments) {
            return $post_comments->created_at->format('d-m-Y h:i a');
        })
        ->rawColumns(['image','post'])
        ->toJson();
    }
}
