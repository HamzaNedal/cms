<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf
    @isset($method)
        @method("$method")
    @endisset
    <div class="row">
        <div class="col-3">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" value="@isset ($user->name) {{ $user->name }} @else {{ old('name') }} @endisset"  class="form-control">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-3">
            <label for="username">{{ __('Username') }}</label>
            <input type="text" name="username" id="username" value="@isset ($user->username) {{ $user->username }} @else {{ old('username') }} @endisset"  class="form-control">
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-3">
            <label for="email">{{ __('Email') }}</label>
            <input type="text" name="email" id="email" value="@isset ($user->email) {{ $user->email }} @else {{ old('email') }} @endisset"  class="form-control">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-3">
            <label for="mobile">{{ __('Mobile') }}</label>
            <input type="text" name="mobile" id="mobile" value="@isset ($user->mobile) {{ $user->mobile }} @else {{ old('mobile') }} @endisset"  class="form-control">
            @error('mobile')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-3">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" id="password"  class="form-control">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-3">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" id="status" value="{{ old('status') }}" class="form-control">
                <option value="1" @if (isset($user->status) && $user->status == 1) selected @endif >{{ __("Active") }}</option>  
                <option value="0" @if (isset($user->status) && $user->status == 0) selected @endif >{{ __("Inactive") }}</option>  
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-3">
            <label for="receive_email">{{ __('Receive email') }}</label>
            <select name="receive_email" id="receive_email" value="{{ old('receive_email') }}" class="form-control">
                <option value="1" @if (isset($user->receive_email) && $user->receive_email == 1) selected @endif >{{ __("Yes") }}</option>  
                <option value="0" @if (isset($user->receive_email) && $user->receive_email == 0) selected @endif >{{ __("No") }}</option>  
            </select>
            @error('receive_email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-12">
            <label for="permissions">{{ __('Permissions') }}</label>
            <select name="permissions[]" id="permissions" value="{{ old('permissions') }}" class="form-control" multiple> 
                @foreach ($permissions as $id => $display_name)
                    <option value="{{ $id }}" @if(isset($user_permissions)&&in_array($id,$user_permissions)) selected @endif>{{ __("$display_name") }}</option>                    
                @endforeach
            </select>
            @error('permissions')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="bio">{{ __('Bio') }}</label>
        <textarea name="bio" class="summernote" id="bio" cols="30" rows="10">{{ old('bio') }}@isset ($user->bio) {{ $user->bio }} @endisset</textarea>
        @error('bio')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="file-loading">
        <label for="user_image">{{ __('Images') }}</label>
        <input type="file" name="user_image" class="form-control" id="user_image" multiple>
    </div>

    <button type="submit" class="btn btn-primary mt-3">{{ __('Save') }}</button>
</form>