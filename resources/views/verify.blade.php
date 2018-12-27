@extends('layouts.app')

@section('title', __('auth::verify.title'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{--@include('_message')--}}
                <div class="card">
                    <div class="card-header">{{ __('auth::verify.heading') }}</div>
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('auth::verify.resent') }}
                            </div>
                        @endif
                        {{ __('auth::verify.notice') }}
                        <a href="{{route('verification.resend') }}" class="btn btn-link">
                            {{ __('auth::verify.resend') }}
                        </a>
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection
