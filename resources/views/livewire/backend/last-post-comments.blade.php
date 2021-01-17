<div class="row">

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Last Posts</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Title</td>
                                <td>Comments</td>
                                <td>Status</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                            <tr>
                                <td><a href="{{ route('admin.posts.show',$post->id) }}">{{ Str::limit($post->title, 30, '...') }}</a></td>
                                <td>{{ $post->comments->count() }}</td>
                                <td>{{ $post->status() }}</td>
                                <td>{{ $post->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No posts found</td>
                            </tr> 
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <div class="col-lg-6 mb-4">

        <!-- Illustrations -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Last comments</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Comment</td>
                                <td>Status</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($comments as $comment)
                            <tr>
                                <td><a href="{{ route('admin.post_comments.show',$comment->id) }}">{{ Str::limit($comment->name, 30, '...') }}</a></td>
                                <td>{{ Str::limit($comment->comment, 30, '...')  }}</td>
                                <td>{{ $comment->status() }}</td>
                                <td>{{ $comment->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No comments found</td>
                            </tr> 
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
            </div>
            <div class="card-body">
                <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                    CSS bloat and poor page performance. Custom CSS classes are used to create
                    custom components and custom utility classes.</p>
                <p class="mb-0">Before working with this theme, you should become familiar with the
                    Bootstrap framework, especially the utility classes.</p>
            </div>
        </div> --}}

    </div>
</div>