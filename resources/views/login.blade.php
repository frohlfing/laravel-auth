@extends('layouts.app')

@section('title', __('auth::login.title'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('auth::login.heading') }}
                    </div>
                    <div class="card-body">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('auth::login.heading') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="{{ config('auth.key') }}" class="col-md-4 col-form-label text-md-right">{{ __('auth::model.' . config('auth.key')) }}</label>
                                <div class="col-md-6">
                                    <input id="{{ config('auth.key') }}" name="{{ config('auth.key') }}" type="{{ config('auth.key') === 'email' ? 'email' : 'text' }}" value="{{ old(config('auth.key')) }}" required="required" autofocus="autofocus" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth::model.password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" name="password" type="password" required="required" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked="checked"' : '' }} class="form-check-input"/>
                                        <label class="form-check-label" for="remember">
                                            {{ __('auth::login.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i> {{ __('auth::login.submit') }}
                                    </button>
                                    @if (config('auth.forgot_password'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('auth::login.forgot_password') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
