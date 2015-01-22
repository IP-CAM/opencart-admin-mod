{{ Form::open(['route' => 'admin.module.update', 'method' => 'put', $module->id]) }}
	
	@foreach ($avalibleLanguages as $code => $language)
		<h3>{{ $code }}</h3>
		{{ Form::label('Title') }}
		{{ Form::text("languages[{$code}][title]", Input::old("languages[{$code}][title]", $language->title)) }}

		{{ Form::label('Description') }}
		{{ Form::textarea("languages[{$code}][description]", Input::old("languages[{$code}][description]", $language->description)) }}
		<hr>
	@endforeach

	{{ Form::submit('Save') }}
{{ Form::close() }}