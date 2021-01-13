@extends('layouts.app')

@section('content')
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <h3>{{ __('Create Post') }}</h3>

                <form action="{{ route('user.store.post') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea name="description" class="summernote" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="category_id">{{ __('Category') }}</label>
                            <select name="category_id" id="category_id" value="{{ old('category_id') }}" class="form-control">
                                @foreach ($categories as $id => $name)
                              
                                    <option value="{{ $id }}">{{ $name }}</option>  
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="comment_able">{{ __('Comment Able') }}</label>
                            <select name="comment_able" id="comment_able" value="{{ old('comment_able') }}" class="form-control">
                                <option value="1">{{ __("Yes") }}</option>  
                                <option value="0">{{ __("No") }}</option>  
                            </select>
                            @error('comment_able')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="status">{{ __('Comment Able') }}</label>
                            <select name="status" id="status" value="{{ old('status') }}" class="form-control">
                                <option value="1">{{ __("Active") }}</option>  
                                <option value="0">{{ __("Inactive") }}</option>  
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="file-loading">
                        <label for="post-images">{{ __('Images') }}</label>
                        <input type="file" name="images[]" class="form-control" id="post-images" multiple>
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
@endsection
@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

@endpush
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous"> --}}
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" /> --}}
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous"> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/plugins/piexif.min.js" type="text/javascript"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/plugins/sortable.min.js" type="text/javascript"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> --}}
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/fileinput.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/themes/fas/theme.min.js"></script> --}}

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
        }
    );
</script>
@endpush