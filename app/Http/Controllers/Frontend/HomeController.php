<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentForPostOwnerNotify;
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
        $posts = Post::with(['user', 'media'])
            ->whereHas('category', function ($query) {
                $query->active();
            })->whereHas('user', function ($query) {
                $query->active();
            })
            ->post()->active()->descById()->paginate(5);
        return view('frontend.index', compact('posts'));
    }


    public function show_post($slug)
    {
        $post = Post::with(['category', 'user', 'media', 'approved_comments'])
            ->active()
            ->wherePostType('post')
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
            if(!$post){
                abort(404);
           }
        return view('frontend.post', compact('post'));
    }
    public function show_page($slug)
    {
        $page = Post::with(['user'])
            ->whereHas('user', function ($query) {
                $query->active();
            })
            ->wherePostType('page')
            ->active()
            ->whereSlug($slug)
            ->first();
           if(!$page){
                abort(404);
           }
           return view('frontend.page', compact('page'));
    }
    public function store_comment(Request $request, Post $post)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'url'       => 'nullable|url',
            'comment'   => 'required|min:10',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        if ($post->post_type == 'post' && $post->status == 1) {

            $userId = auth()->check() ? auth()->id() : null;
            $data['name']           = $request->name;
            $data['email']          = $request->email;
            $data['url']            = $request->url;
            $data['ip_address']     = $request->ip();
            $data['comment']        = Purify::clean($request->comment);
            $data['post_id']        = $post->id;
            $data['user_id']        = $userId;

            $comment = $post->comments()->create($data);
            // dd($comment);
            if (auth()->guest() || auth()->id() != $post->user_id) {
                $post->user->notify(new NewCommentForPostOwnerNotify($comment));
            }

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


    public function contact_us()
    {
        return view('frontend.contact');
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
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data['name']       = $request->name;
        $data['email']      = $request->email;
        $data['mobile']     = $request->mobile;
        $data['title']      = $request->title;
        $data['message']    = $request->message;

        Contact::create($data);

        return redirect()->back()->with([
            'message' => 'Message sent successfully',
            'alert-type' => 'success'
        ]);
    }

    public function search(Request $request )
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;

        $posts = Post::with(['media', 'user'])
            ->whereHas('category', function ($query) {
                $query->active();
            })
            ->whereHas('user', function ($query) {
                $query->active();
            });
          
        if ($keyword != null) {
            $posts = $posts->search($keyword, null, true);
            
        }

        $posts = $posts->post()->active()->orderBy('id', 'desc')->paginate(5);

        return view('frontend.index', compact('posts'));
    }

    public function category(Category $category){
     
        // $category = $category->active()->first()->id;

        if ($category->status == 1) {
            $posts = Post::with(['media','user'])
                     ->whereCategoryId($category->id)
                     ->post()
                     ->active()
                     ->descById()
                     ->paginate(5);
        
            return view('frontend.index',compact('posts'));
        }

        return redirect()->route('home');
    }

    public function archive($date)
    {
       $explodeed_date = explode('-',$date);
       $month = $explodeed_date[0];
       $year = $explodeed_date[1];

       $posts = Post::with(['media','user','category'])
       ->withCount('approved_comments')
       ->whereMonth('created_at',$month)
       ->whereYear('created_at',$year)
       ->post()
       ->active()
       ->descById()
       ->paginate(5);

       return view('frontend.index',compact('posts'));
    }


    public function author(User $user)
    {
    
        if ($user->status == 1) {
            $posts = Post::with(['media','user','user'])
                     ->withCount('approved_comments')
                     ->whereUserId($user->id)
                     ->post()
                     ->active()
                     ->descById()
                     ->paginate(5);

            return view('frontend.index',compact('posts'));
        }

        return redirect()->route('home');
    }


}
