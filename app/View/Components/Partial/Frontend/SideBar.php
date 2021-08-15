<?php

namespace App\View\Components\Partial\Frontend;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\CacheData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class SideBar extends Component
{
    use CacheData;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    { 
        if(!Cache::has('recent_posts')){
          
            $recent_posts = Post::with(['category', 'user', 'media'])
            ->whereHas('category', function ($query) {
                $query->active();
            })->whereHas('user', function ($query) {
                $query->active();
            })
            ->post()
            ->active()
            ->descById()
            ->limit(5)
            ->get();
            Cache::remember('recent_posts', 3600, function ()use($recent_posts) {
                return $recent_posts;
            });
        }
        if(!Cache::has('recent_comments')){
            $recent_comments = Comment::active()->descById()->limit(5)->get();
            Cache::remember('recent_comments', 3600, function ()use($recent_comments) {
                return $recent_comments;
            });
        }
        if(!Cache::has('global_archives')){
            $global_archives = Post::active()->post()
            ->select(DB::raw('extract(year from "updated_at") as year'),DB::raw('extract(month from "updated_at") as month'))
            ->orderBy('year','asc')
            ->pluck('year','month')
            ->map(function($value,$key){
                return Carbon::create($value,$key);
            })
            ->sortDesc()
            ->map(function($value,$key){
                return $value->isoFormat('MMMM YYYY');
            });
           
            Cache::remember('global_archives', 3600, function () use ($global_archives) {
                return $global_archives;
            });
          
        }
       
        $recent_posts = Cache::get('recent_posts');
        $recent_comments = Cache::get('recent_comments');
        $global_archives = Cache::get('global_archives');
       
        $recent_categories = $this->recent_categories();
        // dd($recent_categories);
        return view('components.partial.frontend.side-bar',compact('recent_posts','recent_comments','global_archives','recent_categories'));
    }
}
