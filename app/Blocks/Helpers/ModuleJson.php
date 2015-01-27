<?php namespace Blocks\Helpers;

use Illuminate\Filesystem\Filesystem;
use Blocks\Helpers\ModuleZip;
use Blocks\Helpers\Exceptions\InvatidCodeException;

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
    protected function getModuleJsonPath($moduleCode)
    {
        if ($moduleCode == 'uploaded-module')
        {
            return base_path("tmp/uploaded-module/module.json");
        }

        // At that point we only have public/modules/module.zip file
        // Firstly we have to unzip this module to be able to read
        // module.json file
        $this->moduleZip->unzip(
            "public/modules/{$moduleCode}.zip",
            "public/modules/{$moduleCode}"
        );

        return base_path("public/modules/{$moduleCode}/module.json");
    }

    /**
     * Here we will get content of module.json and store it
     * whisine this class ($this->moduleInfo)
     *
     * @return mixed
     */
    public function describe($moduleCode)
    {
    	$json = $this->filesystem->get($this->getModuleJsonPath($moduleCode));
    	$this->moduleInfo = json_decode($json);

        // Remove temporary zip file (created in $this->getModuleJsonPath)
        $this->filesystem->deleteDirectory(base_path("public/modules/{$moduleCode}"));

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

    public function getCode()
    {
        if (empty($this->grab('code')))
        {
            throw new InvatidCodeException("Module shouldn't be empty!");
        }

        return $this->grab('code');
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
