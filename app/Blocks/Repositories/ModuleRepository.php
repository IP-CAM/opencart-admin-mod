<?php namespace Blocks\Repositories;

use Blocks\Models\Module;
use Input;
use ZipArchive;
use File;
use Exception;

class ModuleRepository
{

	protected $listPath;
	protected $module;
	
	function __construct(Module $module)
	{
		$this->listPath = base_path() . '/public/modules/';

		$this->module = $module;
	}

	public function all()
	{
		return $this->module->all();
	}


	/**
	 * Unzip module to temporary folder in order to read module.json
	 *
	 * @return bool
	 */
	public function handleUploadedModule($module)
	{
		$zip = new ZipArchive;
		$res = $zip->open($module);

		if ($res === TRUE)
		{
		    $zip->extractTo(base_path() . '/tmp/uploaded-module');
		    $zip->close();

		    return true;
		}

		throw new Exception("Can't open uploaded module!");
	}


	/**
	 * Read uploaded module.json
	 *
	 * @return String
	 */
	public function readUploadedModule()
	{
		$moduleJson = File::get(base_path() . '/tmp/uploaded-module/module.json');

		if ( ! $moduleJson)
		{
			throw new Exception("module.json doesn't exists");
		}
		
		return json_decode($moduleJson);
	}

	/**
	 * Store new module in database and move module zip file to `modules catalog`
	 *
	 * @return void
	 */
	public function storeModule($zip, $json)
	{
		if ( ! $this->copyModuleZip($zip))
		{
			throw new Exception("Can't copy module zip file");
		}

		$this->updateModuleInfo($json);
	}

	/**
	 * Update module info in the database
	 *
	 * @return bool
	 */
	protected function updateModuleInfo($json)
	{
		$module = $this->module->where('code', $json->name)->first();

		if ($module->id)
		{
			return $this->create($json);
		}

		return $this->update($json);
	}

	/**
	 * Copy module zip file
	 *
	 * @return bool
	 */
	protected function copyModuleZip($zip)
	{
		return File::copy($zip, $this->listPath);
	}


}