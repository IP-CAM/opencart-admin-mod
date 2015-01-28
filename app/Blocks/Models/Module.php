<?php namespace Blocks\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	
	protected $guarded = [];

	public function information()
	{
		return $this->hasMany('Blocks\Models\ModuleLanguage');
	}

	/**
	 * Check if module is free or not
	 *
	 * @return mixed
	 */
	public function scopeIsFree($q)
	{
		return $q->where('price', '0')->first();
	}

	/**
	 * Find module by code
	 *
	 * @return mixed
	 */
	public function scopeGetIdByCode($q, $moduleCode)
	{
		return $q->where('code', $moduleCode)->first()->pluck('id');
	}

	/**
	 * Get module with related language
	 *
	 * @return mixed
	 */
	public function scopeWithLanguages($q, $language_code)
	{
		return $q->with(['information' => function($q) use ($language_code)
		{
			$q->where('language_code', $language_code);
		}]);
	}

	/**
	 * Get published modules (`status` = 1)
	 *
	 * @return mixed
	 */
	public function scopePublished($q, $language_code)
	{
		return $q
			->withLanguages($language_code)
			->where('status', 1);
	}
	
}