@extends('layouts.app')

@section('title', __('profile.title'))

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
                        {{__('profile.heading')}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('users.model.name') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{$user->name}}
                            </div>
                        </div>
                        @if (config('auth.key') !== 'email')
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 highlight">
                                    {{ __('users.model.' . config('auth.key')) }}
                                </div>
                                <div class="col-xs-12 col-sm-9">
                                    {{ $user->getAttribute(config('auth.key')) }}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('users.model.email') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                {{ $user->email}}
                                @if(!$user->confirmed)
                                    <div>
                                        <i class="fas fa-exclamation-circle" style="color:red;" title="{{ __('profile.email_not_confirmed') }}"></i>
                                        <i>{{ __('profile.email_not_confirmed') }}</i>
                                        <a href="{{route('auth.verification.send') }}" class="btn btn-link">
                                            {{ __('profile.resend_email') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 highlight">
                                {{ __('users.model.api_token') }}
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <span id="api-token">{{ $user->api_token }}</span>
                                <a href="{{ route('profile.api-token.renew') }}" data-method="PATCH" data-confirm="{{ __('profile.renew_api_token_hint') }}" class="btn btn-link">
                                    {{ __('profile.renew_api_token') }}
                                </a>
                                <button id="copy-button" type="button" class="btn btn-link" data-succesful="{{ __('profile.copied_api_token') }}"  data-failed="{{ __('profile.copy_failed') }}">
                                    {{ __('common.buttons.copy') }}
                                </button>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-xs-12 col-sm-9 col-sm-offset-3">
                                <a href="{{route('profile.edit')}}" class="btn btn-sm btn-info" title="{{ __('common.edit') }}">
                                    <i class="fas fa-pencil-alt"></i>
                                    {{__('common.buttons.edit')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection