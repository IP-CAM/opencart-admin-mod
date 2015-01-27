<?php namespace Blocks\Repositories;

use Blocks\Models\Key;
use Blocks\Models\Module;

class KeyRepository
{
	
	protected $keyModel;
	protected $module;

	function __construct(Key $keyModel, Module $module)
	{
		$this->keyModel = $keyModel;
		$this->module = $module;
	}

	public function all()
	{
		return $this->keyModel->all();
	}

	/**
	 * Check if key exists in database
	 *
	 * @return number
	 */
	public function exists($key)
	{
		return $this->keyModel->where('code', $key)->count();
	}

	/**
	 * Find key by module id and domain name
	 *
	 * @return mixed
	 */
	public function byModuleAndDomain($moduleCode, $domain)
	{
		return $this->keyModel
			->where('module_code', $moduleCode)
			->where('domain', $domain)
			->first();
	}

	/**
	 * Save key in the database
	 *
	 * @return bool
	 */
	public function store($key, $moduleCode, $domain)
	{
		$this->keyModel->module_code = $moduleCode;
		$this->keyModel->domain = $domain;
		$this->keyModel->code = $key;

		return $this->keyModel->save();
	}

}