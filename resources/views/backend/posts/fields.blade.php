<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf
    @isset($method)
        @method("$method")
    @endisset
    <div class="form-group">
        <label for="title">{{ __('Title') }}</label>
        <input type="text" name="title" id="title" value="@isset ($post->title) {{ $post->title }} @else {{ old('title') }} @endisset"  class="form-control">
        @error('title')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">{{ __('Description') }}</label>
        <textarea name="description" class="summernote" id="description" cols="30" rows="10">{{ old('description') }}@isset ($post->description) {{ $post->description }} @endisset</textarea>
        @error('description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="row">
        <div class="col-4">
            <label for="category_id">{{ __('Category') }}</label>
            <select name="category_id" id="category_id" value="{{ old('category_id') }}"  class="form-control">
                @foreach ($categories as $id => $name)
              
                    <option value="{{ $id }}" @if(isset($post->category_id) && $post->category_id == $id) selected @endif>{{ $name }}</option>  
                @endforeach
            </select>
            @error('category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-4">
            <label for="comment_able">{{ __('Comment Able') }}</label>
            <select name="comment_able" id="comment_able" value="{{ old('comment_able') }}" class="form-control">
                <option value="1" @if (isset($post->comment_able) && $post->comment_able == 1) selected @endif >{{ __("Yes") }}</option>  
                <option value="0" @if (isset($post->comment_able) && $post->comment_able == 0) selected @endif >{{ __("No") }}</option>  
            </select>
            @error('comment_able')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-4">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" id="status" value="{{ old('status') }}" class="form-control">
                <option value="1" @if (isset($post->status) && $post->status == 1) selected @endif >{{ __("Active") }}</option>  
                <option value="0" @if (isset($post->status) && $post->status == 0) selected @endif >{{ __("Inactive") }}</option>  
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