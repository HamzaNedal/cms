@extends('layouts.app')

@section('content')

     <!-- Start Blog Area -->
     <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="blog-page">
                        <div class="page__header">
                            <h2 style="Text-Transform:capitalize !important; ">Category : {{  request()->segment(count(request()->segments())) ? str_replace('-',' ',request()->segment(count(request()->segments()))): 'all'  }}</h2>
                        </div>
                        <!-- Start Single Post -->
                       
                        @forelse ($posts as $post)
                        <article class="blog__post d-flex flex-wrap">
                            <div class="thumb">
                                <a href="{{ route('posts.show',$post->slug )}}">
                                    @if ($post->media->count()>0)
                                        <img src="{{ asset('assets/posts/'.$post->media->first()->file_name) }}" alt="blog images">
                                        @else
                                        <img src="{{ asset('frontend') }}/images/blog/blog-3/1.jpg" alt="blog images">
                                    @endif
                                </a>
                            </div>
                            <div class="content">
                                <h4><a href="{{ route('posts.show',$post->slug )}}">{{ $post->title }}</a></h4>
                                <ul class="post__meta">
                                    <li>Posts by : <a href="{{ route('posts.show',$post->slug )}}">{{ $post->user->name }}</a></li>
                                    <li class="post_separator">/</li>
                                    <li>{{ $post->created_at->format('M d Y') }}</li>
                                </ul>
                                <p>{{ Str::limit($post->description, 145, '...') }}</p>
                                <div class="blog__btn">
                                    <a class="shopbtn" href="{{ route('posts.show',$post->slug )}}">read more</a>
                                </div>
                            </div>
                        </article>
                       
                        @empty
                            <div class="text-center">No posts</div>
                        @endforelse ($posts as $post)

                        <!-- End Single Post -->
                    </div>
                    {{ $posts->links('pagination::blog') }}
                    {{-- <ul class="wn__pagination">
                       
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li>
                    </ul> --}}
                </div>
                <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                  <x-partial.frontend.side-bar/>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Area -->
@endsection