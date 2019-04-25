@extends('auth::layouts.app')

@section('title', __('auth::profile.title'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{--@include('_errors')--}}
                <div class="card">
                    <div class="card-header">
                        {{ __('auth::profile.heading') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('profile.update') }}" accept-charset="UTF-8" class="form-horizontal">
                            <input name="_method" value="PATCH" type="hidden"/>
                            <input name="_token" value="{{csrf_token() }}" type="hidden"/>
                            {{--<div class="form-group row">--}}
                                {{--<label for="image" class="col-md-4 col-form-label text-md-right">Image</label>--}}
                                {{--<div class="col-md-10">--}}
                                    {{--<input name="image" value="{{old('image') ?: $user->image}}" type="hidden" class="imageupload"--}}
                                        {{--data-folder="articles"--}}
                                        {{--data-max-size="480x480"--}}
                                        {{--data-thumbnail-size="100x100"--}}
                                    {{--/>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">
                                    {{ __('auth::model.name') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="name" name="name" value="{{old('name') ?: $user->name}}" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('auth::model.name') }}" maxlength="255" required="required" autofocus="autofocus"/>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if(config('auth.key') !== 'email')
                                <div class="form-group row">
                                    <label for="{{ config('auth.key') }}" class="col-md-4 col-form-label text-md-right">
                                        {{ __('auth::model.' . config('auth.key')) }}
                                    </label>
                                    <div class="col-md-6">
                                        <input id="{{ config('auth.key') }}" value="{{ $user->getAttribute(config('auth.key')) }}" type="text" class="form-control" readonly="readonly"/>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">
                                    {{ __('auth::model.email') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="email" value="{{$user->email}}" type="email" class="form-control" readonly="readonly"/>
                                    @if(!$user->hasVerifiedEmail())
                                        <div style="padding-top: 5px">
                                            <i class="fas fa-exclamation-circle" style="color:red" title="{{ __('auth::profile.email_not_verified') }}"></i>
                                            <i>{{ __('auth::profile.email_not_verified') }}</i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @includeIf('auth::profile._form')
                            {{--<div class="form-group row">--}}
                                {{--<label for="api_token" class="col-md-4 col-form-label text-md-right">--}}
                                    {{--{{ __('auth::model.api_token') }}--}}
                                {{--</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input id="api_token" value="{{old('api_token') ?: $user->api_token}}" type="text" class="form-control{{ $errors->has('api_token') ? ' is-invalid' : '' }}" placeholder="{{ __('auth::model.api_token') }}" readonly="readonly"/>--}}
                                    {{--@if ($errors->has('api_token'))--}}
                                        {{--<span class="invalid-feedback" role="alert">--}}
                                            {{--<strong>{{$errors->first('api_token') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <hr/>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-save" aria-hidden="true"></i> {{ __('.buttons.save') }}
                                    </button>
                                    <a href="{{route('profile.index') }}" class="btn btn-secondary">
                                        {{ __('.buttons.cancel') }}
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