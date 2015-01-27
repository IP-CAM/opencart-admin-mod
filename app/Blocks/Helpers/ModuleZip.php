<?php namespace Blocks\Helpers;

use ZipArchive;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FileNotFoundException;

class ModuleZip
{

	protected $filesystem;

	public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

	public function unzip($zipPath, $targetPath = false)
	{
		$targetPath = ($targetPath) ? base_path($targetPath) : base_path('tmp/uploaded-module');

		$zip = new ZipArchive;
		$res = $zip->open($zipPath);

		if ($res === TRUE)
		{
		    $zip->extractTo($targetPath);
		    $zip->close();
		}
	}

	public function copy($zip, $moduleName)
	{
		$path = base_path("public/modules/{$moduleName}.zip");
		
		$this->filesystem->delete($path);

		return $this->filesystem->copy($zip, $path);
	}

    public function find($moduleCode)
    {
    	$path = base_path("public/modules/{$moduleCode}.zip");

    	try { $this->filesystem->get($path); }
    	catch (FileNotFoundException $e) { return false; }

    	return $path;
    }

}
