<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreatePagesRequest;
use App\Http\Requests\Backend\UpdatePagesRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->ability('admin','manage_pages,show_pages')) {
            return abort(403);
        }
        return view('backend.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability('admin','create_pages')) {
            return abort(403);
        }
        return view('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePagesRequest $request)
    {
        $request['post_type'] = 'page';
        $request['category_id'] = 1;
        $page = auth()->user()->posts()->create($request->all());

        if ($page->status == 1) {
            Cache::forget('pages');
        }
        return redirect()->route('admin.pages.index')->with([
            'message' => 'Page created successfully',
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

        if (!\auth()->user()->ability('admin', 'display_pages')) {
            return redirect('admin/index');
        }
        $page = Page::with(['category'])->whereId($id)->wherePostType('page')->first();
        
        return view('backend.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        if (!auth()->user()->ability('admin','update_pages')) {
            return abort(403);
        }
        // $categories = Category::whereStatus(1)->pluck('name', 'id');
        return view('backend.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePagesRequest $request,Page $page)
    {

        $page->update($request->all());
        Cache::forget('pages');
        return redirect()->route('admin.pages.index')->with([
            'message' => 'Page updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if (!auth()->user()->ability('admin','delete_pages')) {
            return abort(403);
        }
        
        $page->delete();
        Cache::forget('pages');
        return redirect()->route('admin.pages.index')->with([
            'message' => 'Post deleted successfully',
            'alert-type' => 'success',
        ]);
    }


    public function datatable()
    {
        if (!auth()->user()->ability('admin','manage_pages,show_pages')) {
            return abort(403);
        }
        $pages = Page::isPage()->get();
        return DataTables::of($pages)
            ->editColumn('status', function ($page) {
                return $page->status();
            })
            ->editColumn('created_at', function ($page) {
                return $page->created_at->format('d-m-Y h:i a');
            })
            ->editColumn('username', function ($page) {
                return $page->user->name;
            })
            ->editColumn('title', function ($page) {
                return "<a href='".route("admin.pages.show",$page->id)."'>$page->title</a>";
            })
            ->editColumn('actions', function ($page) {
                $page->route = 'pages';
                return view('backend.datatables.actions')->with(['model' => $page]);
            })->rawColumns(['title'])
            ->toJson();
    }
}
