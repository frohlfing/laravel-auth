@extends('layouts.app')

@section('title', __('auth::confirm.title'))

@section('content')
    <div class="container">
        @if ($user !== null && $user->confirmed)
            <h3>{{ __('auth::confirm.hello', ['name' => $user->name]) }}!</h3>
            <p>{{ __('auth::confirm.welcome') }}</p>
            @if (auth()->guest())
                <a href="{{ route('login') }}" class="btn btn-sm btn-info">
                    <i class="fa fa-btn fa-sign-in"></i> {{__('auth::confirm.login') }}
                </a>
            @endif
        @endif
    </div>
@endsection