<?php

namespace App\View\Components\Partial\Frontend;

use App\Models\Page;
use App\Traits\CacheData;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Header extends Component
{
    use CacheData;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        // $categories = Category::whereStatus(1)->get();
        if(!Cache::has('pages')){
            $pages = Page::isPage()->active()->get();
            Cache::remember('pages', 3600, function ()use($pages) {
                return $pages;
            });
        }
       
        $recent_categories = $this->recent_categories();
        $pages = Cache::get('pages');
        return view('components.partial.frontend.header', compact('pages','recent_categories'));
    }


    // public function categories()
    // { 
    //     return Category::whereStatus(1)->get();
    // }
    // public function pages()
    // {

    //     return Page::isPage()->get();
    // }
}
