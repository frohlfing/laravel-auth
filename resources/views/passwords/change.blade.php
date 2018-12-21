@extends('layouts.app')

@section('title', __('auth::password.title'))

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">{{ __('auth::password.heading') }}</div>
					<div class="card-body">
						<form method="POST" action="{{ route('password.change') }}" aria-label="{{ __('auth::password.heading') }}">
							@csrf
							<div class="form-group row">
								<label for="old_password" class="col-md-4 col-form-label text-md-right">{{ __('auth::password.current_password') }}</label>
								<div class="col-md-6">
									<input id="old_password" name="old_password" type="password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" required="required" autofocus="autofocus"/>
									@if ($errors->has('old_password'))
										<span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth::password.new_password') }}</label>
								<div class="col-md-6">
									<input id="password" name="password" type="password" class="password-meter form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" minlength="{{ config('auth.password_length') }}" maxlength="255" required="required"/>
									@if ($errors->has('password'))
										<span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('auth::password.confirm_password') }}</label>
								<div class="col-md-6">
									<input id="password-confirm" name="password_confirmation" type="password" class="form-control" maxlength="255" required="required"/>
								</div>
							</div>
							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-primary">
										{{ __('auth::password.submit') }}
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
