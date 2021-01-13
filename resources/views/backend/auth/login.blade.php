@extends('layouts.admin--auth')
@section('content')
<div class="card-body p-0">
    <!-- Nested Row within Card Body -->
    <div class="row">
        <div class="col-lg-6  d-lg-block ">
            <img src="{{ asset('assets/images/computer-repair.jpg') }}" alt="computer repair" width="465px" height="438px">
        </div>
        <div class="col-lg-6">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                </div>
                <form class="user" action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="username" name="username" class="@error('username') is-invalid @enderror form-control form-control-user"
                            id="exampleInputusername" aria-describedby="usernameHelp"
                            placeholder="Enter Username ..." value="{{ old('username') }}">
                        @error('username')
                            <span class="invalid-feedback" role="alert" style="display: block;!important">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-user"
                            id="exampleInputPassword" placeholder="Password" >
                            @error('password')
                            <span class="invalid-feedback" role="alert" style="display: block;!important">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" name="rememberme" class="custom-control-input" id="customCheck">
                            <label class="custom-control-label" for="customCheck">Remember
                                Me</label>
                        </div>
                    </div>
                   
                    <button type="submit" class="btn btn-primary btn-user btn-block">{{ __('Login') }}</button>
                    <hr>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="{{ route('admin.password.request') }}">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection