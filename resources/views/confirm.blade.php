@extends('layouts.app')

@section('title', __('auth::confirm.title'))

@section('content')
    <div class="container">
        @if ($user !== null && $user->hasVerifiedEmail())
            <h3>{{ __('auth::confirm.hello', ['name' => $user->name]) }}!</h3>
            <p>{{ __('auth::confirm.welcome') }}</p>
        @endif
    </div>
@endsection