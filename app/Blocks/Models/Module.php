<?php namespace Blocks\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	
	protected $guarded = [];

	public function scopePublished($q)
	{
		return $q->whereStatus(1);
	}
	
}