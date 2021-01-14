@extends('layouts.admin')
@section('content')

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">Contact Us ({{ $contact_u->title }})</h6>
                <div class="ml-auto">
                    <a href="{{ route('admin.contact_us.index') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">Contact Us</span>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>Title</th>
                            <td colspan="4"><a href="{{ route('admin.contact_us.show', $contact_u->id) }}">{{ $contact_u->title }}</a></td>
                        </tr>
                        <tr>                            
                            <th>Name</th>
                            <td>{{ $contact_u->name }}</td>
                        </tr>
                        <tr>                            
                            <th>email</th>
                            <td>{{ $contact_u->email }}</td>
                        </tr>
                        <tr>                            
                            <th>mobile</th>
                            <td>{{ $contact_u->mobile }}</td>
                        </tr>
                        <tr>
                            <th>Created date</th>
                            <td>{{ $contact_u->created_at->format('d-m-Y h:i a') }}</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="4">
                                <div class="row">
                                    @if($pages->media->count() > 0)
                                        @foreach($pages->media as $media)
                                            <div class="col-2">
                                                <img src="{{ asset('assets/pagess/' . $media->file_name) }}" class="img-fluid">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
       
    </div>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                    <h6 class="m-0 font-weight-bold text-primary">Message</h6>
            </div>
            <div class="card-body">
               {{ $contact_u->message }}}
            </div>
            
        </div>
       
    </div>
    {{-- <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">Comments</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Author</th>
                        <th width="40%">comment</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($post->comments as $comment)
                        <tr>
                            <td><img src="{{ get_gravatar($comment->email, 50) }}" class="img-circle"></td>
                            <td>{{ $comment->name }}</td>
                            <td>{!! $comment->comment !!}</td>
                            <td>{{ $comment->status() }}</td>
                            <td>{{ $comment->created_at->format('d-m-Y h:i a') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.post_comments.edit', $comment->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="if (confirm('Are you sure to delete this comment?') ) { document.getElementById('comment-delete-{{ $comment->id }}').submit(); } else { return false; }" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    <form action="{{ route('admin.post_comments.destroy', $comment->id) }}" method="post" id="comment-delete-{{ $comment->id }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No comments found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
   

   

@endsection