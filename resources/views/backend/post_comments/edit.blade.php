@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-blod text-primary">Edit comment</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.post_comments.index') }}" class="btn btn-primary">
                     <span class="icon text-white-50">
                         <i class="fa fa-home"></i>
                     </span>
                     <span class="text">Comments</span>
                </a>
             </div>
        </div>
        <div class="card-body">
            
            @include('backend.post_comments.fields',['route' => route('admin.post_comments.update',$post_comment->id),'method'=>"put"])
        </div>
    </div>
</div>
@endsection