@extends('layouts.app')


@section('content')
         <!-- Start Blog Area -->
         <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Post</td>
                                        <td>Status</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($comments as $comment)
                                    <tr>
                                        <td>{{ $comment->name }}</td>
                                        <td>{{ $comment->post->title }}</td>
                                        <td>{{ $comment->status }}</td>
                                        <td>
                                            <a href="{{ route('user.comment.edit',$comment->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure ? ')){document.getElementById('comment-dide-{{$comment->id }}').submit(); }else {return false;}"><i class="fa fa-trash"></i></a>
                                            <form action="{{ route('user.comment.destroy',$comment->id) }}" method="post" class="d-none" id="comment-dide-{{ $comment->id }}">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">No posts found</td>
                                        
                                    </tr>
                                    @endforelse
                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">{{ $comments->links('pagination::blog') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                      <x-partial.frontend.users.side-bar/>
                    </div>
                
                </div>
            </div>
        </div>
        <!-- End Blog Area -->
@endsection