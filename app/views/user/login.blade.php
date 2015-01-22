<ul>
	@if (Session::has('auth_fail'))
		<li>Authorization failed</li>
	@endif

	@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
</ul>

{{ Form::open(['mehod' => 'post', 'route' => 'admin.login_post']) }}
	{{ Form::label('Login') }}
	{{ Form::input('text', 'login', Input::old('login', '')) }}

	{{ Form::label('Password') }}
	{{ Form::input('password', 'password', Input::old('password', '')) }}

	{{ Form::submit() }}
{{ Form::close() }}