<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf
    @isset($method)
        @method("$method")
    @endisset
    <div class="form-group">
        <label for="title">{{ __('Title') }}</label>
        <input type="text" name="title" id="title" value="@isset ($page->title) {{ $page->title }} @else {{ old('title') }} @endisset"  class="form-control">
        @error('title')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">{{ __('Description') }}</label>
        <textarea name="description" class="summernote" id="description" cols="30" rows="10">{{ old('description') }}@isset ($page->description) {{ $page->description }} @endisset</textarea>
        @error('description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="row">

        <div class="col-4">
            <label for="status">{{ __('Comment Able') }}</label>
            <select name="status" id="status" value="{{ old('status') }}" class="form-control">
                <option value="1" @if (isset($page->status) && $page->status == 1) selected @endif >{{ __("Active") }}</option>  
                <option value="0" @if (isset($page->status) && $page->status == 0) selected @endif >{{ __("Inactive") }}</option>  
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">{{ __('Save') }}</button>
</form>