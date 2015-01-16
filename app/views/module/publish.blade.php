{{ Form::open(['action' => 'post', 'route' => 'module.publish', 'enctype' => 'multipart/form-data']) }}
	<input type="file" name="module">

	<input type="submit" value="Submit">
{{ Form::close() }}