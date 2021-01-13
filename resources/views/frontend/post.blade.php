@extends('layouts.app')

@section('content')
<div class="page-blog-details section-padding--lg bg--white">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="blog-details content">
                    <article class="blog-post-details">
                        <div class="post-thumbnail">
                            @if ($post->media->count()>0)
                            <img src="{{ asset('assets/posts/'.$post->media->first()->file_name) }}" alt="blog images">
                        @else
                            <img src="{{ asset('frontend') }}/images/blog/big-img/1.jpg" alt="blog images">
                        @endif         
                        </div>
                        <div class="post_wrapper">
                            <div class="post_header">
                                <h2>{{ $post->title }}</h2>
                                <ul class="post_author">
                                    <li>Posts by : <a href="{{ route('author.posts',$post->user->username) }}">{{ $post->user->name }}</a></li>
                                    <li class="post-separator">/</li>
                                    <li>{{ $post->created_at->format('M d Y') }}</li>
                                </ul>
                            </div>
                            <div class="post_content">
                                <p class="">{!! $post->description !!}</p>

                            </div>
                            <ul class="blog_meta">
                                <li><a href="#">{{ $post->approved_comments->count() }} comments</a></li>
                                <li> / </li>
                                <li>Category : <span>{{ $post->category->name }}</span></li>
                            </ul>
                            <ul class="social__net--4 d-flex justify-content-start">
                                <li><a href="#"><i class="zmdi zmdi-rss"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-vimeo"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-tumblr"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </article>
                    <div class="comments_area">
                        <h3 class="comment__title">{{ $post->approved_comments->count() }} comments</h3>
                        <ul class="comment__list">
                            @forelse ($post->approved_comments as $comment)
                            <li>
                                <div class="wn__comment">
                                    <div class="thumb">
                                        <img src="{{ get_gravatar($comment->email,46) }}" alt="comment images">
                                    </div>
                                    <div class="content">
                                        <div class="comnt__author d-block d-sm-flex">
                                            <span><a href="#">{{ $comment->name }}</a> Post author</span>
                                            <span>{{ $comment->created_at->format('M d Y h:i a') }}</span>
                
                                        </div>
                                        <p>{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            </li>
                            @empty
                                <div>No Comments</div>
                            @endforelse
                           
                        </ul>
                    </div>
                    <div class="comment_respond">
                        <h3 class="reply_title">Leave a Reply <small><a href="#">Cancel reply</a></small></h3>
                        <form class="comment__form" method="post" action="{{ route('add.comment',['post'=>$post->slug]) }}">
                            @csrf
                            <p>Your email address will not be published.Required fields are marked </p>
                            <div class="input__box">
                                <label>Comment</label>
                                <textarea name="comment">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input__wrapper clearfix">
                                <div class="input__box name one--third">
                                    <label>Name</label>
                                    <input type="text" placeholder="name" value="{{ old('name') }}" name="name">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                                <div class="input__box email one--third">
                                    <label>email</label>
                                    <input type="email" placeholder="email" value="{{ old('email') }}" name="email">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                                <div class="input__box website one--third">
                                    <label>Website</label>
                                    <input type="text" value="{{ old('url') }}" name="url" placeholder="website">
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
                <x-partial.frontend.side-bar/>
            </div>
        </div>
    </div>
</div>
@endsection