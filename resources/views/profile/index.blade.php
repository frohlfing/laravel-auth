@extends('layouts.app')

@section('title', __('auth::profile.title'))

@section('scripts')
    <script>
        jQuery(document).ready(function($) {
            $('#copy-button').click(function () {
                var token = $('#api-token').text();
                var ok = copyToClipboard(token);
                modalAlert('', $(this).data(ok ? 'succesful' : 'failed'));
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .card-body .row {
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('_message')
                @include('_errors')
                <div class="card">
                    <div class="card-header">
                        {{ __('auth::profile.heading') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('auth::model.name') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{$user->name}}
                            </div>
                        </div>
                        @if (config('auth.key') !== 'email')
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 highlight">
                                    {{ __('auth::model.' . config('auth.key')) }}
                                </div>
                                <div class="col-xs-12 col-sm-9">
                                    {{ $user->getAttribute(config('auth.key')) }}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('auth::model.email') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{ $user->email}}
                                @if(!$user->confirmed)
                                    <div>
                                        <i class="fas fa-exclamation-circle" style="color:red;" title="{{ __('auth::profile.email_not_confirmed') }}"></i>
                                        <i>{{ __('auth::profile.email_not_confirmed') }}</i>
                                        <a href="{{route('auth.verification.send') }}" class="btn btn-link">
                                            {{ __('auth::profile.resend_email') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if(config('auth.manage_api'))
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 highlight">
                                    {{ __('auth::model.api_token') }}
                                </div>
                                <div class="col-xs-12 col-sm-9">
                                    <span id="api-token">{{ $user->api_token }}</span>
                                    <a href="{{ route('profile.api-token.renew') }}" data-method="PATCH" data-confirm="{{ __('auth::profile.renew_api_token_hint') }}" class="btn btn-link">
                                        {{ __('auth::profile.renew_api_token') }}
                                    </a>
                                    <button id="copy-button" type="button" class="btn btn-link" data-succesful="{{ __('auth::profile.copied_api_token') }}"  data-failed="{{ __('auth::profile.copy_failed') }}">
                                        {{ __('common.buttons.copy') }}
                                    </button>
                                </div>
                            </div>
                        @endif
                        <hr/>
                        <div class="row">
                            <div class="col-xs-12 col-sm-9 col-sm-offset-3">
                                <a href="{{route('profile.edit')}}" class="btn btn-sm btn-info" title="{{ __('common.edit') }}">
                                    <i class="fas fa-pencil-alt"></i>
                                    {{ __('common.buttons.edit') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection