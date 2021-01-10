@extends('layouts.app')

@section('content')
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <h3>{{ __('Create Post') }}</h3>

                <form action="{{ route('user.update.post',$post->slug) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="slug" value="{{ $post->slug }}">
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $post->title ) }}" class="form-control">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea name="description" class="summernote" id="description" cols="30" rows="10">{{ old('description',$post->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="category_id">{{ __('Category') }}</label>
                            <select name="category_id" id="category_id" value="{{ old('category_id',$post->category_id) }}" class="form-control">
                                @foreach ($categories as $id => $name)
                              
                                    <option value="{{ $id }}"  @if ($post->category_id == $id ) selected @endif>{{ $name }}</option>  
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="comment_able">{{ __('Comment Able') }}</label>
                            <select name="comment_able" id="comment_able" value="{{ old('comment_able',$post->comment_able) }}" class="form-control">
                                <option value="1" @if ($post->comment_able == 1) selected @endif>{{ __("Yes") }}</option>  
                                <option value="0" @if ($post->comment_able == 0) selected @endif>{{ __("No") }}</option>  
                            </select>
                            @error('comment_able')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="status">{{ __('Comment Able') }}</label>
                            <select name="status" id="status" value="{{ old('status',$post->status) }}" class="form-control"  aria-modal="true">
                                <option value="1" @if ($post->status == 1) selected @endif>{{ __("Active") }}</option>  
                                <option value="0" @if ($post->status == 0) selected @endif>{{ __("Inactive") }}</option>  
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="file-loading">
                        <label for="post-images">{{ __('Images') }}</label>
                        <input type="file" name="images[]" class="form-control" id="post-images" data-preview-file-type="text" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">{{ __('Save') }}</button>
                </form>
            </div>
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                <x-partial.frontend.users.side-bar/>
            </div>
        </div>
      
    </div>
</div>

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.3/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

@endpush
@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.3/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.3/themes/fa/theme.js"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
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
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
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
                        {caption:"{{ $media->file_name }}",size:{{ $media->file_size }},width:"120px",url:"{{ route('user.post.media.destroy',[$media->id,'_token'=>csrf_token()]) }}",key:"{{ $media->id }}"},
                    @endforeach
                @endif
                
            
            ],
            layoutTemplates: {
               
                actionDelete: '<button type="button" class="kv-file-remove {removeClass}" title="{removeTitle}"{dataUrl}{dataKey}><i class="fa fa-trash"></i></button>\n',
                actionZoom: '<button type="button" class="kv-file-zoom {zoomClass}" title="{zoomTitle}"><i class="fa fa-search-plus"></i></button>',            
                actionZoom: '<button type="button" class="kv-file-zoom {zoomClass}" title="{zoomTitle}"><i class="fa fa-search-plus"></i></button>',            
                
            },
        }
    );
</script>
@endpush
@endsection
