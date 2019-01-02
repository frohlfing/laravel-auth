@extends('auth::layouts.app')

@section('title', __('auth::reset.title'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('auth::reset.heading') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('auth::reset.heading') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}"/>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth::model.email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" name="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $email ?? old('email') }}" maxlength="255" required="required" autofocus="autofocus"/>
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
                                    <input id="password" name="password" type="password" class="password-meter form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" minlength="{{ config('auth.password_length') }}" maxlength="255" required="required"/>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('auth::reset.confirm_password') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" name="password_confirmation" type="password" class="form-control" maxlength="255" required="required"/>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('auth::reset.submit') }}
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
