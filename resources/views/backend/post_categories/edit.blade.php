@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-blod text-primary">Edit Category</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.post_categories.index') }}" class="btn btn-primary">
                     <span class="icon text-white-50">
                         <i class="fa fa-home"></i>
                     </span>
                     <span class="text">Categories</span>
                </a>
             </div>
        </div>
        <div class="card-body">
        
            @include('backend.post_categories.fields',['route' => route('admin.post_categories.update',$post_category->id),'method'=>"put"])
        </div>
    </div>
</div>
@endsection