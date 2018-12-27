@extends('layouts.app')

@section('title', __('auth::register.title'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('auth::register.heading') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('auth::register.heading') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('auth::model.name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" name="name" type="text" value="{{ old('name') }}" maxlength="255" required="required" autofocus="autofocus" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"/>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if (config('auth.key') !== 'email')
                                <div class="form-group row">
                                    <label for="{{ config('auth.key') }}" class="col-md-4 col-form-label text-md-right">
                                        {{ __('auth::model.' . config('auth.key')) }}
                                    </label>
                                    <div class="col-md-6">
                                        <input id="{{ config('auth.key') }}" name="{{ config('auth.key') }}" type="text" value="{{ old(config('auth.key')) }}" maxlength="255" required="required" class="form-control{{ $errors->has(config('auth.key')) ? ' is-invalid' : '' }}"/>
                                        @if($errors->has(config('auth.key')))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first(config('auth.key')) }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth::model.email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" required="required" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"/>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth::model.password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" name="password" type="password" minlength="{{ config('auth.password_length') }}" maxlength="255" required="required" class="password-meter form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"/>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('auth::register.confirm_password') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" name="password_confirmation" type="password" maxlength="255" required="required" class="form-control"/>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('auth::register.submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
