<ul>
	@foreach ($modules as $module)
		<li>
			Title: {{ $module->information->first()->title }}<br>
			Version: {{ $module->version }}<br>
			Price: {{ $module->price }}<br>
			Status: {{ $module->status }}<br>
			{{ HTML::linkRoute('admin.module.edit', 'Edit', [$module->code]) }}
		</li>
	@endforeach
</ul>