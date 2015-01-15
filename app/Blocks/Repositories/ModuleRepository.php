<?php namespace Blocks\Repositories;

use Blocks\Models\Module;
use Input;
use ZipArchive;
use File;
use Exception;

class ModuleRepository
{

	protected $tmpModulePath;

	protected $listPath;
	protected $module;
	
	function __construct(Module $module)
	{
		$this->listPath = base_path() . '/public/modules';
		$this->tmpModulePath = base_path() . '/tmp/uploaded-module';

		$this->module = $module;

		$this->createModuleDirectories();
	}

	protected function createModuleDirectories()
	{
		@mkdir($this->listPath, 0777);
		@mkdir($this->tmpModulePath, 0777);
	}

	public function all()
	{
		return $this->module->all();
	}

	public function update($json)
	{
		$module_id = $this->module->where('code', $json->name)->pluck('id');

		$module = Module::find($module_id);
		$module->version = $json->version;
		$module->price = 0;
		
		return $module->save();
	}

	public function create($json)
	{
		$module = $this->module;
		$module->code = $json->name;
		$module->version = $json->version;
		$module->price = 0;
		$module->downloads = 0;
		
		return $module->save();
	}

	/**
	 * Unzip module to temporary folder in order to read module.json
	 *
	 * @return bool
	 */
	public function handleUploadedZip($uploadedZip)
	{
		$zip = new ZipArchive;
		$res = $zip->open($uploadedZip);

		if ($res === TRUE)
		{
		    $zip->extractTo($this->tmpModulePath);
		    $zip->close();

		    return $this->readUploadedModuleJson();
		}

		throw new Exception("Can't open uploaded module!");
	}


	/**
	 * Read uploaded module.json
	 *
	 * @return String
	 */
	protected function readUploadedModuleJson()
	{
		$moduleJson = File::get($this->tmpModulePath . '/module.json');

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
	public function store($zip, $json)
	{
		if ( ! $this->copyModuleZip($zip, $json->name))
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

		if (empty($module->id))
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
	protected function copyModuleZip($zip, $name)
	{
		$realModulePath = $this->listPath . "/{$name}.zip";

		File::delete($realModulePath);

		return File::copy($zip, $realModulePath);
	}


}