<?php namespace Blocks\Helpers;

use ZipArchive;
use Illuminate\Filesystem\Filesystem;

class ModuleZip
{

	protected $filesystem;

	public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

	public function unzip($zipPath, $targetPath = 'tmp/uploaded-module')
	{
		$targetPath = $targetPath ?: base_path($targetPath);

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
		$path = base_path('public/modules') . "/{$moduleName}.zip";

		$this->filesystem->delete($path);

		return $this->filesystem->copy($zip, $path);
	}

}
