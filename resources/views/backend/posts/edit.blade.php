@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-blod text-primary">Edit post</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">
                     <span class="icon text-white-50">
                         <i class="fa fa-home"></i>
                     </span>
                     <span class="text">Posts</span>
                </a>
             </div>
        </div>
        <div class="card-body">
            
            @include('backend.posts.fields',['route' => route('admin.posts.update',$post->id),'method'=>"put"])
        </div>
    </div>
</div>
@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
@endpush
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('.summernote').summernote({
        tabsize: 2,
        height: 300,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    });

    $("#post-images").fileinput(
        {
            theme: "fa",
            maxFileCount: {{ 5-$post->media->count() }},
            allowedFileTypes: ['image'],
            showCancel: true,
            showRemove: true,
            showUpload: false,
            overwriteInitial: false,

            initialPreview:[
                @if($post->media->count()>0)
                    @foreach ($post->media as $media)
                        "{{ asset('assets/posts/'.$media->file_name) }}",
                    @endforeach
                @endif
            ],
            initialPreviewAsData:true,
            initialPreviewFileType:'image',
            initialPreviewConfig:[
                @if($post->media->count()>0)
                    @foreach ($post->media as $media)
                        {caption:"{{ $media->file_name }}",size:{{ $media->file_size }},width:"120px",url:"{{ route('admin.post.media.destroy',[$media->id,'_token'=>csrf_token()]) }}",key:"{{ $media->id }}"},
                    @endforeach
                @endif
                
            
            ],
        }
    );
</script>
@endpush
@endsection