<?php namespace Blocks\Repositories;

use Blocks\Models\Module;
use Blocks\Helpers\ModuleJson;

class ModuleRepository
{

	protected $module;

	public function __construct(Module $module)
	{
		$this->module = $module;
	}

	/**
	 * Find module by his unique code
	 *
	 * @return mixed
	 */
	public function find($moduleName)
	{
		return $this->module->whereCode($moduleName)->first();
	}

	/**
	 * Get all published modules (with status = true)
	 *
	 * @return mixed
	 */
	public function published()
	{
		return $this->module->published()->get();
	}

	/**
	 * Save module info
	 *
	 * @return bool
	 */
	public function save(ModuleJson $moduleInfo)
	{
		$module = $this->find($moduleInfo->getName());

		if ($module)
		{
			$module = $this->module->find($module->id);
			$module->code = $moduleInfo->getName();
			$module->version = $moduleInfo->getVersion();
			return $module->save();
		}

		$this->module->code = $moduleInfo->getName();
		$this->module->version = $moduleInfo->getVersion();
		return $this->module->save();
	}

}