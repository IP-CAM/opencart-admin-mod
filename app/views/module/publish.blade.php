{{ Form::open(['action' => 'post', 'route' => 'module.publish', 'enctype' => 'multipart/form-data']) }}
	<input type="file" name="module">

	{{ Form::input('hidden', 'secret', '$2y$10$Pgfs10ZAAxP9pRkT2UrGxuRWH.PZSBIUZ5dexKT1T7NOdEO3XMqci') }}

	<input type="submit" value="Submit">
{{ Form::close() }}