{{ Form::open(['method' => 'put', $module->id]) }}
	
	@foreach ($avalibleLanguages as $code => $language)
		<h3>{{ $code }}</h3>
		{{ Form::label('Title') }}
		{{ Form::text($code . '[title]', Input::old($code . '[title]', $language->title)) }}

		{{ Form::label('Description') }}
		{{ Form::textarea($code . '[description]', Input::old($code . '[description]', $language->description)) }}
		<hr>
	@endforeach

	{{ Form::submit('Save') }}
{{ Form::close() }}