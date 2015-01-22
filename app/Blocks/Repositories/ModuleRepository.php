<?php namespace Blocks\Repositories;

use Blocks\Models\Module;
use Blocks\Models\ModuleLanguage;
use Blocks\Models\Language;
use Blocks\Helpers\ModuleJson;

class ModuleRepository
{

	protected $module;
	protected $moduleLanguage;
	protected $language;

	public function __construct(Module $module, ModuleLanguage $moduleLanguage, Language $language)
	{
		$this->module = $module;
		$this->moduleLanguage = $moduleLanguage;
		$this->language = $language;
	}

	/**
	 * Find module by his unique code
	 *
	 * @return mixed
	 */
	public function find($moduleCode, $language_code)
	{
		return $this
			->module
			->withLanguages($language_code)
			->whereCode($moduleCode)->first();
	}

	/**
	 * Get all published modules (with status = true)
	 *
	 * @return mixed
	 */
	public function published($language_code)
	{
		return [
			'language_code' => $language_code,
			'modules' => $this->module->published($language_code)->get()
		];
	}

	/**
	 * Get module avalible languages
	 *
	 * @return mixed
	 */
	public function getAvalibleLanguages($moduleId)
	{
		$result = [];
		$languages = $this->language->lists('code');

		foreach ($languages as $language)
		{
			$result[$language] = $this->moduleLanguage
				->where('module_id', $moduleId)
				->where('language_code', $language)
				->first();
		}

		return $result;
	}

	/**
	 * Save module info (called when user update module via console command)
	 *
	 * @return bool
	 */
	public function save(ModuleJson $moduleInfo)
	{
		$module = $this->find($moduleInfo->getName(), 'en');

		if ($module)
		{
			$module = $this->module->find($module->id);
			$module->code = $moduleInfo->getName();
			$module->version = $moduleInfo->getVersion();
			return $module->save();
		}

		$this->module->code = $moduleInfo->getName();
		$this->module->version = $moduleInfo->getVersion();
		return $this->module->save();
	}

	/**
	 * Save module langs via admin panel
	 *
	 * @return void
	 */
	public function saveLanguages($moduleCode, $languages)
	{
		$moduleId = $this->module->getIdByCode($moduleCode);

		// Remove all language of module
		$this->moduleLanguage->removeByModuleId($moduleId);

		// Save new languages
		$data = array_map(function($language, $languageCode)
		{
			return new ModuleLanguage([
				'title' => $language['title'],
				'language_code' => $languageCode,
				'description' => $language['description']
			]);
		}, $languages, array_keys($languages));

		$this->module->find($moduleId)->information()->saveMany($data);
	}

}