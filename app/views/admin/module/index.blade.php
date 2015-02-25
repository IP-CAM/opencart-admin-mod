<ul class="module-list">
	@foreach ($modules as $module)
		<li class="module">
			<figure class="module-logo">
				{{ HTML::image($module->logo, $module->information->first()->title, ['width' => 150]) }}
			</figure>
			Title: {{ $module->information->first()->title }}<br>
			Version: {{ $module->version }}<br>
			Price: {{ $module->price }}<br>
			Status: {{ $module->status }}<br>
			{{ HTML::linkRoute('admin.module.edit', 'Edit', [$module->code]) }}
		</li>
	@endforeach
</ul>

<style type="text/css">
	.module-list {
		overflow: hidden;
		padding: 0;
	}
	.module-list .module {
		float: left;
		width: 100%;
		border: 1px solid #cecece;
		margin: 10px 0;
		padding: 5px 10px;
		box-sizing: border-box;
	}
	.module-list .module .module-logo {
		float: left;
	}
</style>