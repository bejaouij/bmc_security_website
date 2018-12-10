@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My profile') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile_update') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="user_firstname" class="col-md-4 col-form-label text-md-right">{{ __('Firstname') }}</label>

                            <div class="col-md-6">
                                <input id="user_firstname" type="text" class="form-control{{ $errors->has('user_firstname') ? ' is-invalid' : '' }}" name="user_firstname" value="{{ Auth::user()->user_firstname }}" required autofocus>

                                @if ($errors->has('user_firstname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_lastname" class="col-md-4 col-form-label text-md-right">{{ __('Lastname') }}</label>

                            <div class="col-md-6">
                                <input id="user_lastname" type="text" class="form-control{{ $errors->has('user_lastname') ? ' is-invalid' : '' }}" name="user_lastname" value="{{ Auth::user()->user_lastname }}" required autofocus>

                                @if ($errors->has('user_lastname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone number') }}</label>

                            <div class="col-md-6">
                                <input id="user_phone_number" type="text" class="form-control{{ $errors->has('user_phone_number') ? ' is-invalid' : '' }}" name="user_phone_number" value="{{ Auth::user()->user_phone_number }}" required autofocus>

                                @if ($errors->has('user_phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Auth::user()->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                @if(Session::has('message'))
	                <div class="justify-content-center">
	                	<div class="alert alert-success" role="alert">
		                	{{ Session::get('message') }}
		                </div>
	                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection