<form id="payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8">
	<input type="hidden" name="ik_co_id" value="54d38c70bf4efcad3252c4df" />
	<input type="hidden" name="ik_pm_no" value="{{ $module->code }}:{{ $domain }}" />
	<input type="hidden" name="ik_am" value="{{ $module->price }}" />
	<input type="hidden" name="ik_cur" value="USD" />
	<input type="hidden" name="ik_desc" value="{{ $module->information->first()->title }}" />
	<input type="hidden" name="ik_sign" value="821nsSUuTIN/njMBN/cs8Q==">

    <div class="box">
    	<div class="form-group">
    		{{ Form::label('module', 'Module:') }}
    		{{ Form::select('module', $modules) }}
    	</div>

	    <div class="form-group">
	    	{{ Form::label('domain', 'Domain:') }}
	    	{{ Form::text('domain', $domain) }}
	    </div>
	    
	    <input type="submit" value="GO">
    </div>
</form>