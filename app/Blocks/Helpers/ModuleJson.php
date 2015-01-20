<?php namespace Blocks\Helpers;

use Illuminate\Filesystem\Filesystem;
use Blocks\Helpers\ModuleZip;

class ModuleJson
{

	protected $filesystem;
    protected $moduleInfo;
	protected $moduleZip;

    public function __construct(Filesystem $filesystem, ModuleZip $moduleZip)
    {
        $this->filesystem = $filesystem;
        $this->moduleZip = $moduleZip;
    }

    /**
     * Get module parametr value (ex. $this->moduleInfo->version)
     *
     * @return string
     */
    protected function grab($param)
    {
    	return empty($this->moduleInfo->{$param}) ? '' : $this->moduleInfo->{$param};
    }

    /**
     * Here we will get module absolute json file path
     * in order to read module info.
     *
     * If module is uploaded -> then path is simple link to tmp/uploaded-module
     * If module is in public/modules -> then we have to unzip it first
     *
     * @return string
     */
    protected function getModuleJsonPath($moduleName)
    {
        if ($moduleName == 'uploaded-module')
        {
            return base_path("tmp/uploaded-module/module.json");
        }

        // At that point we only have public/modules/module.zip file
        // Firstly we have to unzip this module to be able to read
        // module.json file
        $this->moduleZip->unzip(
            base_path("public/modules/{$moduleName}.zip"),
            base_path("public/modules/{$moduleName}")
        );

        return base_path("public/modules/{$moduleName}/module.json");
    }

    /**
     * Here we will get content of module.json and store it
     * whisine this class ($this->moduleInfo)
     *
     * @return mixed
     */
    public function describe($moduleName)
    {
    	$json = $this->filesystem->get($this->getModuleJsonPath($moduleName));
    	$this->moduleInfo = json_decode($json);

        // Remove temporary zip file (created in $this->getModuleJsonPath)
        $this->filesystem->deleteDirectory(base_path("public/modules/{$moduleName}"));

    	return $this;
    }

    /**
     * Override module info params (ex. module version)
     * Ex. $this->moduleInfo->versiton = value;
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
