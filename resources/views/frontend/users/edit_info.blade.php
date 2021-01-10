@extends('layouts.app')
@section('content')
<div class="page-blog-details section-padding--lg bg--white">
    <div class="container">
        <div class="row">
            
    <div class="col-lg-9 col-12" >
        <h3>Update Information</h3>
        <form action="{{ route('user.update_info') }}" method="post" id="user_info" enctype="multipart/form-data" class="mb-3">
            @csrf
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="" value="{{ old('name', auth()->user()->name) }}" class='form-control'>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="" value="{{ old('email', auth()->user()->email) }}" class='form-control'>
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="mobile">mobile</label>
                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile', auth()->user()->mobile) }}" class='form-control'>
                    @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="receive_email">{{ __('Receive email') }}</label>
                    <select name="receive_email" id="receive_email" value="{{ old('receive_email') }}" class="form-control">
                        <option value="1"@if (auth()->user()->receive_email == 1) selected @endif>{{ __("Yes") }}</option>  
                        <option value="0"@if (auth()->user()->receive_email == 0) selected @endif>{{ __("No") }}</option>  
                    </select>
                    @error('receive_email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="bio">{{ __('Bio') }}</label>
                    <textarea name="bio" class="form-control">{{ old('bio',auth()->user()->bio) }}</textarea>
                    @error('bio')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            @if (auth()->user()->user_image != '')
                <div class="col-12">
                    <img src="{{ asset('assets/users/' . auth()->user()->user_image) }}" class="img-fluid" width="150" alt="{{ auth()->user()->name }}">
                </div>
            @endif
            <div class="col-12">
                <div class="form-group">
                    <label for="user_image">{{ __('User image') }}</label>
                    <input type="file" name="user_image" class='form-control'>
                    {{-- {!! Form::file('user_image', ['class' => 'custom-file']) !!} --}}
                    @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    {{-- {!! Form::submit('Update information', ['name' => 'update_information', 'class' => 'btn btn-primary']) !!} --}}
                    <input type="submit" value="Update information" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>

        <hr>

        <h3 class="mt-5">Update Password</h3>
        <form action="{{ route('user.update_password') }}" method="post" id="user_password" enctype="multipart/form-data">
            @csrf
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="current_password">{{ __('Current password') }}</label>
                    <input type="password" name="current_password" class='form-control' id="current_password">
                    @error('current_password')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="password">{{ __('New password') }}</label>
                    <input type="password" name="password" class='form-control' id="password">
                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Re Password') }}</label>
                    <input type="password" name="password_confirmation" class='form-control' id="password_confirmation">
                
                    @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    {{-- {!! Form::submit('Update Password', ['name' => 'update_password', 'class' => 'btn btn-primary']) !!} --}}
                    <input type="submit" value="Update information" class="btn btn-primary">
                </div>
            </div>
        </div>
        </form>
        {{-- {!! Form::close() !!} --}}

    </div>

    <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
        <x-partial.frontend.users.side-bar/>
    </div>
        </div>
    </div>
</div>
@endsection