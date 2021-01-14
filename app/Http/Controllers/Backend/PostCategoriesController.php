<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreatePostCategoriesRequest;
use App\Http\Requests\Backend\UpdatePostCategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class PostCategoriesController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->ability('admin','manage_post_categories,show_post_categories')) {
            return abort(403);
        }
        return view('backend.post_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability('admin','create_post_categories')) {
            return abort(403);
        }
        return view('backend.post_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostCategoriesRequest $request)
    {
        $categoy = Category::create($request->all());

        if ($categoy->status == 1) {
            Cache::forget('recent_post_categories');
        }

        return redirect()->route('admin.post_categories.index')->with([
            'message' => 'Categoy created successfully',
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

        if (!auth()->user()->ability('admin','show_post_categories')) {
            return abort(403);
        }
        // $post = Post::with(['media', 'category', 'user', 'comments'])->whereId($id)->wherePostType('post')->first();
        // return view('backend.post_categories.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $post_category)
    {

        if (!auth()->user()->ability('admin','update_post_categories')) {
            return abort(403);
        }
        return view('backend.post_categories.edit', compact('post_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostCategoriesRequest $request,Category $post_category)
    {
        $post_category->update($request->all());
        Cache::forget('recent_post_categories');
        return redirect()->route('admin.post_categories.index')->with([
            'message' => 'Category updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $post_category)
    {
        if (!auth()->user()->ability('admin','delete_post_categories')) {
            return abort(403);
        }
        $post_category->delete();
        return redirect()->route('admin.post_categories.index')->with([
            'message' => 'Category deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    public function datatable()
    {
        if (!auth()->user()->ability('admin','manage_post_categories,show_post_categories')) {
            return abort(403);
        }
        $post_categories = Category::query();
        return DataTables::of($post_categories)
        ->editColumn('status', function ($post_categories) {
            return $post_categories->status();
        })
        ->addColumn('post_count', function ($post_categories) {
            return $post_categories->posts->count();
        })
        ->editColumn('actions', function ($post_categories) {
            $post_categories->route = 'post_categories';
            return view('backend.datatables.actions')->with(['model' => $post_categories]);
        })->toJson();
    }
}
