{{ Form::open(['route' => ['admin.module.update', $module->code], 'method' => 'put', 'files' => true]) }}
	
	<h1>
		{{ $avalibleLanguages['en']->title }}

		@if ($zip)
			<small>Module zip - <span class="green">OK</span></small>
		@else
			<small>Module zip - <span class="red">NOT UPLOADED</span></small>
		@endif
	</h1>

	<hr>

	{{ Form::label('price', 'Price') }}
	{{ Form::text('price', Input::old('price', $module->price)) }}

	{{ Form::label('version', 'Version') }}
	{{ Form::text('version', Input::old('version', $module->version)) }}

	{{ Form::label('images', 'Images') }}
	{{ Form::file('images[]', ['multiple' => true]) }}

	<label>Status: {{ Form::checkbox('status', 'Y', Input::old('status', $module->status)) }}</label>

	<hr>

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