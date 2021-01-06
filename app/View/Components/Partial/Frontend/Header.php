<?php

namespace App\View\Components\Partial\Frontend;

use App\Helper\CategorySingleton;
use App\Models\Category;
use App\Models\Page;
use Illuminate\View\Component;

class Header extends Component
{
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
        $categories = Category::whereStatus(1)->get();
        $pages = Page::isPage()->get();
        return view('components.partial.frontend.header', compact('categories', 'pages'));
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
