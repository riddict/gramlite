@extends('layouts.app')

@section('content')
	<div class="sign-in-wthree">
		<div class="sign-in-top-agileinfo">
			<h2>Login</h2>
			<p>Access gram client</p>
		</div>
		<div class="sign-in-bottom-agileinfo">
			<form role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
				<h3>Email Address</h3>
				<input type="text" name="email" value="{{ old('email') }}" required autofocus>
				@if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
				<h3>Password</h3>
				<input type="password" name="password" required>
				@if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
				<label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
				<input type="submit" value="Login"/>
				<p>Forgot Password? </p><a href="{{ url('/password/reset') }}">Click Here</a><br />
				<p>Register </p><a href="{{ url('/register') }}">Here</a>
			</form>
		</div>
	</div>
@endsection
