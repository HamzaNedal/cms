<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf
    @isset($method)
        @method("$method")
    @endisset
    

    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <label for="name">{{ __('name') }}</label>
                <input type="text" name="name" id="name" value="@isset ($post_category->name) {{ $post_category->name }} @else {{ old('name') }} @endisset"  class="form-control">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-8">
            <label for="status">{{ __('Comment Able') }}</label>
            <select name="status" id="status" value="{{ old('status') }}" class="form-control">
                <option value="1" @if (isset($post_category->status) && $post_category->status == 1) selected @endif >{{ __("Active") }}</option>  
                <option value="0" @if (isset($post_category->status) && $post_category->status == 0) selected @endif >{{ __("Inactive") }}</option>  
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">{{ __('Save') }}</button>
</form>