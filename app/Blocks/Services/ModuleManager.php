<?php namespace Blocks\Services;

use ZipArchive;
use Blocks\Services\Exceptions\BrokenZipException;
use Blocks\Services\Exceptions\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class ModuleManager
{

	protected $basePath;
	protected $unziper;
	protected $filesystem;

	public function __construct($basePath, Unziper $unziper, Filesystem $filesystem)
	{
		$this->basePath = $basePath;
		$this->unziper = $unziper;
		$this->filesystem = $filesystem;
	}

	public function handle($zip)
	{
		if ($this->unziper->unzip($zip, $this->getTempModulePath()))
		{
			return true;
		}

		return false;
	}

	protected function getTempModulePath()
	{
		return $this->basePath . '/tmp/uploaded-module';
	}

	protected function getListPath()
	{
		return $this->basePath . '/public/modules';
	}

	public function describeUploaded()
	{
		$path = $this->getTempModulePath() . '/module.json';
		$json = $this->filesystem->get($path);
		
		return json_decode($json);
	}

	public function copy($zip, $name)
	{
		$realModulePath = $this->getListPath() . "/{$name}.zip";

		$this->filesystem->delete($realModulePath);

		return $this->filesystem->copy($zip, $realModulePath);
	}

}