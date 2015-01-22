<?php namespace Blocks\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleLanguage extends Model
{

	protected $guarded = [];

	public function scopeRemoveByModuleId($q, $moduleId)
	{
		return $q->where('module_id', $moduleId)->delete();
	}

}