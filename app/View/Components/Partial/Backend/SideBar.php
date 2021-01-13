<?php

namespace App\View\Components\Partial\Backend;

use App\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class SideBar extends Component
{
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
        if(!Cache::has('admin_side_menu')){

            Cache::forever('admin_side_menu', Permission::tree());
        }
     
        $admin_side_menu = Cache::get('admin_side_menu');
        return view('components.partial.backend.side-bar',compact('admin_side_menu'));
    }
}
