@extends('layouts.app')

@section('content')
<div class="page-blog-details section-padding--lg bg--white">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="blog-details content"> 
                    <div class="comment_respond">
                        <h3 class="reply_title">Comment For Post : <a href="{{ route('posts.show', $comment->post->slug ) }}">{{ $comment->post->title }}</a><small><a href="#"></a></small></h3>
                        <form class="comment__form" method="post" action="{{ route('user.comment.update',$comment->id) }}">
                            @csrf
                            <div class="input__box">
                                <label>Comment</label>
                                <textarea name="comment">{{ old('comment',$comment->comment) }}</textarea>
                                @error('comment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input__wrapper clearfix">
                                <div class="input__box name one--third">
                                    <label>Name</label>
                                    <input type="text" placeholder="name" value="{{ old('name',$comment->name) }}" name="name">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                                <div class="input__box email one--third">
                                    <label>email</label>
                                    <input type="email" placeholder="email" value="{{ old('email',$comment->email) }}" name="email">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                                <div class="input__box website one--third">
                                    <label>Website</label>
                                    <input type="text" value="{{ old('url',$comment->url) }}" name="url" placeholder="website">
                                    @error('url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>

                                <div class="input__box website one--third">
                                    <label>Status</label>
                                    <select name="status" id="status" value="{{ old('status') }}" class="form-control">
                                        <option value="1" @if ($comment->status == 1) selected @endif>{{ __("Active") }}</option>  
                                        <option value="0" @if ($comment->status == 0) selected @endif>{{ __("Inactive") }}</option>  
                                    </select>
                                    @error('url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                                
                            </div>
                            <div class="submite__btn input__box  one--third">
                                <input type="submit" value="Post Comment">
                            </div>
                        </form>
                    </div>
                </div>
               
            </div>
            
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                <x-partial.frontend.users.side-bar/>
            </div>
            </div>
        </div>
    </div>
@endsection