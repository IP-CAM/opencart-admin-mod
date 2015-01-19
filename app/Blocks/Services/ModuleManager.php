<?php namespace Blocks\Services;

use Blocks\Helpers\ModuleZip;
use Blocks\Helpers\ModuleJson;

class ModuleManager
{

	protected $moduleZip;
	protected $moduleJson;

	public function __construct(ModuleZip $moduleZip, ModuleJson $moduleJson)
	{
		$this->moduleZip = $moduleZip;
		$this->moduleJson = $moduleJson;
	}

    public function store($zip)
    {
    	// unzip to tmp/uploaded-module
    	$this->moduleZip->unzip($zip);

    	// read module.json and get module name
    	$moduleInfo = $this->moduleJson->describe('uploaded-module');

    	// copy uploaded module to public/modules/{module_name}
    	$this->moduleZip->copy($zip, $moduleInfo->getName());

        return true;
    }

}
