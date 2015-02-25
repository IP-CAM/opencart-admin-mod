@if (Session::has('successMessage'))
	<div class="alert green">{{ Session::get('successMessage') }}</div>
@endif

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
	<div class="module-images">
		@forelse ($images as $image)
			<a href="{{ $image }}" target="_blank">
				{{ HTML::image($image) }}
				{{ Form::checkbox('remove_image[]', $image) }}
				{{ Form::radio('is_logo', $image, $image == $module->logo) }}
			</a>
		@empty
			<strong>There are not images.</strong>
		@endforelse
	</div>

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

<style>
	.module-images {
		border: 1px solid #CECECE;
		padding: 10px;
		background: #FCFCFC;
		border-radius: 2px;
		margin: 15px 0;
	}
	.module-images a {
		position: relative;
		display: inline-block;
	}
	.module-images img {
		border: 1px solid #cecece;
		padding: 5px;
		width: 300px;
	}
	.module-images input {
		position: absolute;
		top: 10px;
	}
	.module-images input[type=checkbox] {
		right: 10px;
	}
	.module-images input[type=radio] {
		right: 30px;
	}
</style>