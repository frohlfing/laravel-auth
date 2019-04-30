@extends('auth::layouts.app')

@section('title', __('auth::management.show.title'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('auth::management.show.heading', ['name' => $user->name]) }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('auth::model.id') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{ $user->id }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('auth::model.name') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{ $user->name }}
                            </div>
                        </div>
                        @if (config('auth.key') !== 'email')
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 highlight">
                                    {{ __('auth::model.' . config('auth.key')) }}
                                </div>
                                <div class="col-xs-12 col-sm-8">
                                    {{ $user->getAttribute(config('auth.key')) }}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('auth::model.email') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{ $user->email }}
                                @if(!$user->confirmed)
                                    <i class="fas fa-exclamation-circle" style="color:red;" title="{{ __('auth::management.show.email_not_confirmed') }}"></i>
                                    <i>{{ __('auth::management.show.email_not_confirmed') }}</i>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('auth::model.role') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{ $user->role }}
                            </div>
                        </div>
                        @includeIf('auth::management._show')
                        @if(config('auth.manage_api'))
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 highlight">
                                    {{ __('auth::model.api_token') }}
                                </div>
                                <div class="col-xs-12 col-sm-9">
                                    {{ $user->api_token }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 highlight">
                                    {{ __('auth::model.rate_limit') }}
                                </div>
                                <div class="col-xs-12 col-sm-9">
                                    {{ $user->rate_limit }}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('auth::model.created_at') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{ format_datetime($user->created_at) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('auth::model.updated_at') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{ format_datetime($user->updated_at) }}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-xs-12 col-sm-9 col-sm-offset-3">
                                @if(!is_superior($user))
                                    <a href="{{ route('admin.users.edit', [$user->id]) }}" class="btn btn-sm btn-info" title="{{ __('common.edit') }}">
                                        <i class="fas fa-pencil-alt"></i>
                                        {{ __('common.buttons.edit') }}
                                    </a>
                                @endif
                                <a href="{{route('admin.users.index')}}" class="btn btn-sm btn-secondary">{{__('common.buttons.back')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection