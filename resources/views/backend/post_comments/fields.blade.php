<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf
    @isset($method)
        @method("$method")
    @endisset


    <div class="form-group">
        <label for="comment">{{ __('Comment') }}</label>
        <textarea class="form-control" name="comment"  id="comment" cols="30" rows="10">{{ old('comment') }}@isset ($post_comment->comment) {{ $post_comment->comment }} @endisset</textarea>
        @error('comment')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" value="@isset ($post_comment->name) {{ $post_comment->name }} @else {{ old('name') }} @endisset"  class="form-control">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="text" name="email" id="email" value="@isset ($post_comment->email) {{ $post_comment->email }} @else {{ old('email') }} @endisset"  class="form-control">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="url">{{ __('Website') }}</label>
                <input type="text" name="url" id="url" value="@isset ($post_comment->url) {{ $post_comment->url }} @else {{ old('url') }} @endisset"  class="form-control">
                @error('url')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="col-3">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" id="status" value="{{ old('status') }}" class="form-control">
                <option value="1" @if (isset($post_comment->status) && $post_comment->status == 1) selected @endif >{{ __("Active") }}</option>  
                <option value="0" @if (isset($post_comment->status) && $post_comment->status == 0) selected @endif >{{ __("Inactive") }}</option>  
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
    </div>

    <button type="submit" class="btn btn-primary mt-3">{{ __('Save') }}</button>
</form>