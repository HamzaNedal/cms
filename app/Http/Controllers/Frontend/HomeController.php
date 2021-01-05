<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with(['category', 'user', 'media'])
        ->whereHas('category',function($query){
            $query->whereStatus(1);
        })->whereHas('user',function($query){
            $query->whereStatus(1);
        })
        ->wherePostType('post')->whereStatus(1)->orderBy('id', 'desc')->paginate(5);
        return view('frontend.index',compact('posts'));
    }


    public function show_post($slug){
        $post = Post::with(['category', 'user', 'media','approved_comments'])

        ->whereHas('category',function($query){
            $query->whereStatus(1);
        })->whereHas('user',function($query){
            $query->whereStatus(1);
        })->OrwhereHas('approved_comments',function($query){
            $query->orderBy('id','desc');
        })       
        ->wherePostType('post')
        ->whereStatus(1)
        ->whereSlug($slug)
        ->first();

        return view('frontend.post',compact('post'));
    }

    public function store_comment(Request $request,Post $post){
        // dd($request->all());
        $validation = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'url'       => 'nullable|url',
            'comment'   => 'required|min:10',
        ]);
       
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $post = $post->wherePostType('post')->whereStatus(1)->first();
        if ($post) {

            $userId = auth()->check() ? auth()->id() : null;
            $data['name']           = $request->name;
            $data['email']          = $request->email;
            $data['url']            = $request->url;
            $data['ip_address']     = $request->ip();
            $data['comment']        = Purify::clean($request->comment);
            $data['post_id']        = $post->id;
            $data['user_id']        = $userId;

            $comment = $post->comments()->create($data);

            // if (auth()->guest() || auth()->id() != $post->user_id) {
            //     $post->user->notify(new NewCommentForPostOwnerNotify($comment));
            // }

            // User::whereHas('roles', function ($query) {
            //     $query->whereIn('name', ['admin', 'editor']);
            // })->each(function ($admin, $key) use ($comment) {
            //     $admin->notify(new NewCommentForAdminNotify($comment));
            // });

            return redirect()->back()->with([
                'message' => 'Comment added successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }
}
