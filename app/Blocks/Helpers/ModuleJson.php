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

    /**
     * Override module info params (ex. module version)
     *
     * @return void
     */
    public function override($paramCode, $value)
    {
        if (empty($paramCode))
        {
            throw new \InvalidArgumentException("\$paramCode can't be empty");
        }
        
        $this->moduleInfo->{$paramCode} = $value;
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
