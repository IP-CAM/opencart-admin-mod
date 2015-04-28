<?php namespace Blocks\Services;

use Blocks\Helpers\ModuleZip;
use Blocks\Helpers\ModuleJson;
use Blocks\Repositories\ModuleRepository;
use Blocks\Models\Language;

class ModuleManager
{

	protected $moduleZip;
    protected $moduleJson;
	protected $moduleRepository;

	public function __construct(
        ModuleZip $moduleZip, 
        ModuleJson $moduleJson, 
        ModuleRepository $moduleRepository, 
        Language $language
    )
	{
		$this->moduleZip = $moduleZip;
        $this->moduleJson = $moduleJson;
		$this->moduleRepository = $moduleRepository;
        $this->language = $language;
	}

    public function store($zip)
    {
    	// unzip to tmp/uploaded-module
    	$this->moduleZip->unzip($zip);

    	// read module.json and get module name
    	$moduleInfo = $this->moduleJson->describe('uploaded-module');

    	// copy uploaded module to public/modules/{module_name}
    	$this->moduleZip->copy($zip, $moduleInfo->getCode());

        // update module info in db
        $this->moduleRepository->save([
            'code' => $moduleInfo->getCode(), 
            'version' => $moduleInfo->getVersion(),
            'status' => $moduleInfo->getStatus()
        ]);

        // update module languages in db
        $this->moduleRepository->saveLanguages(
            $moduleInfo->getCode(),
            $this->createDummyLanguages($moduleInfo)
        );

        return true;
    }

    /**
     * Check if module exists by its code
     *
     * @return bool
     */
    public function find($moduleCode)
    {
        $path = $this->moduleZip->find($moduleCode);

        if ($path) return $path;

        return false;
    }

    /**
     * Will create dummy languages data
     *
     * @return array
     */
    protected function createDummyLanguages($moduleInfo)
    {
        $result = [];
        $languages = $this->language->lists('code');

        foreach ($languages as $languageCode)
        {
            $result[$languageCode]['title'] = $moduleInfo->getTitle();
            $result[$languageCode]['description'] = $moduleInfo->getDescription();
        }

        return $result;
    }

}
