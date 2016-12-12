@extends('layouts.app')

@section('content')
<div class="sign-in-wthree">
	<div class="sign-in-top-agileinfo">
		<h2>Register</h2>
		<p>To access gram client features.</p>
	</div>
	<div class="sign-in-bottom-agileinfo">
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}
			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			<h3>Name</h3>
			<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
				@if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
			</div>
			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
			<h3>Email Address</h3>
				<input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required>
				@if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
			</div>
			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
			<h3>Password</h3>
				<input id="password" type="password" class="form-control" name="password" required>
					@if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
			</div>
			<div class="form-group">
                <h3>Confirm Password</h3>
				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
			</div>
			<input type="submit" value="Register"/>
			
			</form>
			<p>Login </p><a href="{{ url('login') }}">Here</a>
		</div>
</div>
@endsection
