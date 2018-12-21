@extends('layouts.app')

@section('title', __('auth::management.index.title'))

@section('styles')
    <style>
        td i.not_confirmed-icon {
            color:red;
            margin-left: 5px;
        }
        td a.confirm-button {
            padding: 0;
            margin-left: 5px;
            vertical-align: inherit;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('_message')
                @include('_errors')
                <div class="card">
                    <div class="card-header">
                        {{ __('auth::management.index.heading') }}
                    </div>
                    <div class="card-body">
                        <div class ="row">
                            <div class="col-xs-8 col-sm-6">
                                @include('_search')
                            </div>
                            <div class="col-xs-4 col-sm-6 text-right">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-info" title="{{ __('common.buttons.new') }}">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>{!! sort_column('id', __('auth::model.id')) !!}</th>
                                    <th>{!! sort_column('name', __('auth::model.name')) !!}</th>
                                    @if (config('auth.key') !== 'email')
                                        <th>{!! sort_column('name', __('auth::model.' . config('auth.key'))) !!}</th>
                                    @endif
                                    <th>{!! sort_column('email', __('auth::model.email')) !!}</th>
                                    <th>{!! sort_column('role', __('auth::model.role')) !!}</th>
                                    <th>{!! sort_column('updated_at', __('auth::model.updated_at')) !!}</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            @if (config('auth.key') !== 'email')
                                                <td>{{ $user->getAttribute(config('auth.key')) }}</td>
                                            @endif
                                            <td>
                                                {{ $user->email }}
                                                @if(!$user->confirmed)
                                                    <i class="fas fa-exclamation-circle not_confirmed-icon" title="{{ __('auth::management.index.email_not_confirmed') }}"></i>
                                                    <a href="{{ route('admin.users.confirm', [$user->id]) }}" data-method="PATCH" class="btn btn-link confirm-button">{{ __('auth::management.index.confirm_button') }}</a>
                                                @endif
                                            </td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ format_datetime($user->updated_at) }}</td>
                                            <td class="text-right text-nowrap">
                                                <a href="{{ route('admin.users.show', [$user->id]) }}" class="btn btn-sm btn-info" title="{{ __('common.show') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', [$user->id]) }}" class="btn btn-sm btn-info{{ is_superior($user) ? ' disabled' : '' }}" title="{{ __('common.edit') }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a href="{{ route('admin.users.replicate', [$user->id]) }}" class="btn btn-sm btn-info{{ is_superior($user) ? ' disabled' : '' }}" title="{{ __('common.replicate') }}">
                                                    <i class="fas fa-clone"></i>
                                                </a>
                                                <a href="{{route('admin.users.destroy', array_merge([$user->id], request()->input())) }}" data-method="DELETE" data-confirm="{{ __('common.confirm_deleting') }}" class="btn btn-sm btn-danger delete-button{{ is_superior($user) ? ' disabled' : '' }}" title="{{ __('common.delete') }}">
                                                    <i class="fas fa-trash-alt no-spinner"></i>
                                                </a>
                                                {{--<form method="POST" action="{{ route('admin.users.destroy', array_merge([$user->id], request()->input())) }}" accept-charset="UTF-8" style="display: inline-block;">--}}
                                                    {{--<input type="hidden" name="_method" value="DELETE"/>--}}
                                                    {{--@csrf--}}
                                                    {{--<button type="submit" title="{{ __('common.delete') }}" class="btn btn-sm btn-danger{{ is_superior($user) ? ' disabled' : '' }}" data-confirm="{{ __('common.confirm_deleting') }}">--}}
                                                        {{--<i class="fas fa-trash-alt no-spinner"></i>--}}
                                                    {{--</button>--}}
                                                {{--</form>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($users->isEmpty())
                                        <tr>
                                            <td colspan="100" class="no-hit text-center">
                                                - {{ __('common.no_entries_found') }} -
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {!! str_replace('/?', '?', $users->render()) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
