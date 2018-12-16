@extends('layouts.app')

@section('title', __('package-skeleton::index.title'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    @include('_message')
                    @include('_errors')
                </div>
                <div class="card">
                    <div class="card-header">{{__('package-skeleton::index.heading')}}</div>
                    <div class="card-body">
                        {{__('package-skeleton::index.welcome')}}
                        <br/>Foo: {{ $foo }}
                        <br/>Bar: {{ $bar }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
