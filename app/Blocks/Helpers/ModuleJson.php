<?php namespace Blocks\Helpers;

use Illuminate\Filesystem\Filesystem;

class ModuleJson
{

	protected $filesystem;
	protected $moduleInfo;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    protected function grab($param)
    {
    	return empty($this->moduleInfo->{$param}) ? '' : $this->moduleInfo->{$param};
    }

    protected function getModuleJsonPath($moduleName)
    {
        if ($moduleName == 'uploaded-module')
        {
            return base_path("tmp/uploaded-module/module.json");
        }

        return base_path("public/modules/{$moduleName}/module.json");
    }

    public function describe($moduleName)
    {
    	$json = $this->filesystem->get($this->getModuleJsonPath($moduleName));
    	$this->moduleInfo = json_decode($json);

    	return $this;
    }

    public function getName()
    {
        return $this->grab('name');
    }

    public function getVersion()
    {
        return $this->grab('version');
    }

    public function getTitle()
    {
        return $this->grab('title');
    }

    public function getDescription()
    {
        return $this->grab('description');
    }
    
}
