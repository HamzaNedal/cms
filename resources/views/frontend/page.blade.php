@extends('layouts.app')

@section('content')
<div class="page-blog-details section-padding--lg bg--white">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="blog-details content">
                    <article class="blog-post-details">

                        <div class="post_wrapper">
                            <div class="post_header">
                                <h2>{{ $page->title }}</h2>
                                <ul class="post_author">
                                    <li>Posts by : <a href="#">{{ $page->user->name }}</a></li>
                                    <li class="post-separator">/</li>
                                    <li>{{ $page->created_at->format('M d Y') }}</li>
                                </ul>
                            </div>
                            <div class="post_content">
                                <p>{{ $page->description }}</p>

                            </div>
                        </div>
                    </article>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection