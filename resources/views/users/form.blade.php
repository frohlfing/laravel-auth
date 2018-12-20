@extends('layouts.app')

@section('title', __('users.form.title'))

@section('scripts')
    @include('auth::users._script')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    @include('_message')
                    {{--@include('_errors')--}}
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ __('users.form.heading') . (isset($user->id) ? ' #' . $user->id : '') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.' . (isset($user->id) ? 'update' : 'store'), [$user->id]) }}" accept-charset="UTF-8" class="form-horizontal">
                            @if(isset($user->id))
                                <input name="_method" value="PATCH" type="hidden"/>
                            @endif
                            <input name="_token" value="{{ csrf_token() }}" type="hidden"/>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">
                                    {{ __('users.model.name') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="name" name="name" value="{{ old('name', $user->name) }}" type="text" maxlength="255" required="required" autofocus="autofocus" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('users.model.name') }}"/>
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if (config('auth.key') !== 'email')
                                <div class="form-group row">
                                    <label for="{{ config('auth.key') }}" class="col-md-4 col-form-label text-md-right">
                                        {{ __('users.model.' . config('auth.key')) }}
                                    </label>
                                    <div class="col-md-6">
                                        <input id="{{ config('auth.key') }}" name="{{ config('auth.key') }}" value="{{ old(config('auth.key'), $user->getAttribute(config('auth.key'))) }}" type="text" maxlength="255" required="required" class="form-control{{ $errors->has(config('auth.key')) ? ' is-invalid' : '' }}" placeholder="{{ __('users.model.' . config('auth.key')) }}"/>
                                        @if($errors->has(config('auth.key')))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first(config('auth.key')) }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">
                                    {{ __('users.model.email') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="email" name="email" value="{{ old('email', $user->email) }}" type="email" maxlength="255" required="required" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('users.model.email') }}"/>
                                    {{--@if(isset($user) && !$user->confirmed)--}}
                                        {{--<div style="padding-top: 5px">--}}
                                            {{--<i class="fas fa-exclamation-circle" style="color:red" title="{{ __('users.show.email_not_confirmed') }}"></i>--}}
                                            {{--<i>{{ __('users.form.email_not_confirmed') }}</i>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-md-4 col-form-label text-md-right">
                                    {{ __('users.model.role') }}
                                </label>
                                <div class="col-md-6">
                                    <select id="role" name="role" required="required" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" data-placeholder="{{ __('users.model.role') }}">
                                        <option selected="selected" value=""></option>
                                        @foreach(config('auth.roles') as $role)
                                            @if(!is_superior($role))
                                                <option value="{{ $role }}" {!! $role === old('role', $user->role) ? 'selected="selected"' : '' !!}>{{ $role }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if($errors->has('role'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">
                                    {{ __('users.model.rate_limit') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="rate_limit" name="rate_limit" value="{{ old('rate_limit', $user->rate_limit) }}" type="text" maxlength="10" class="form-control{{ $errors->has('rate_limit') ? ' is-invalid' : '' }}" placeholder="{{ __('users.model.rate_limit') }}"/>
                                    @if($errors->has('rate_limit'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rate_limit') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @if(isset($user->id) && !$errors->has('password') && !$errors->has('password_confirmation'))
                                <div class="panel" style="padding-bottom: 5px">
                                    <a href="#password-panel" data-toggle="collapse">{{ __('users.form.change_password') }}</a>
                                    <div id="password-panel" class="collapse">
                            @endif
                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">
                                                {{ __('users.model.password') }}
                                            </label>
                                            <div class="col-md-6">
                                                <input id="password" name="password" type="password" minlength="{{ config('auth.password_length') }}" maxlength="255" class="password-meter form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('users.model.password') }}"/>
                                                @if($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                                {{ __('users.form.confirm_password') }}
                                            </label>
                                            <div class="col-md-6">
                                                <input id="password-confirm" name="password_confirmation" type="password" title="" maxlength="255" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="{{ __('users.form.confirm_password') }}"/>
                                                @if($errors->has('password_confirmation'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                            @if(isset($user->id) && !$errors->has('password') && !$errors->has('password_confirmation'))
                                    </div>
                                </div>
                            @endif
                            <hr/>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-save" aria-hidden="true"></i> {{ __('common.buttons.save') }}
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        {{ __('common.buttons.cancel') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection