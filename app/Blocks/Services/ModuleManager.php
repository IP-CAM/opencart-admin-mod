<?php namespace Blocks\Services;

use Blocks\Helpers\ModuleZip;
use Blocks\Helpers\ModuleJson;
use Blocks\Repositories\ModuleRepository;

class ModuleManager
{

	protected $moduleZip;
    protected $moduleJson;
	protected $moduleRepository;

	public function __construct(ModuleZip $moduleZip, ModuleJson $moduleJson, ModuleRepository $moduleRepository)
	{
		$this->moduleZip = $moduleZip;
        $this->moduleJson = $moduleJson;
		$this->moduleRepository = $moduleRepository;
	}

    public function store($zip)
    {
    	// unzip to tmp/uploaded-module
    	$this->moduleZip->unzip($zip);

    	// read module.json and get module name
    	$moduleInfo = $this->moduleJson->describe('uploaded-module');

    	// copy uploaded module to public/modules/{module_name}
    	$this->moduleZip->copy($zip, $moduleInfo->getName());

        // update module info in db
        $this->moduleRepository->save($moduleInfo);

        return true;
    }

}
