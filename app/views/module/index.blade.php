<ul>
	@foreach ($modules as $module)
		<li>{{ $module->code }} ({{ $module->version }}) {{ $module->price }}$ </li>
	@endforeach
</ul>