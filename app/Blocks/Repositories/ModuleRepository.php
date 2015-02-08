<?php namespace Blocks\Repositories;

use Blocks\Models\Module;
use Blocks\Models\ModuleLanguage;
use Blocks\Models\Language;
use Blocks\Helpers\ModuleJson;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ModuleRepository
{

	protected $module;
	protected $moduleLanguage;
	protected $language;
	protected $file;

	public function __construct(Module $module, ModuleLanguage $moduleLanguage, Language $language, Filesystem $file)
	{
		$this->module = $module;
		$this->moduleLanguage = $moduleLanguage;
		$this->language = $language;
		$this->file = $file;
	}

	/**
	 * Find module by his unique code
	 *
	 * @return mixed
	 */
	public function find($moduleCode, $language_code = 'en')
	{
		return $this
			->module
			->withLanguages($language_code)
			->whereCode($moduleCode)->first();
	}

	/**
	 * Check if module is free
	 *
	 * @return bool
	 */
	public function isFree($moduleCode)
	{
		return $this->module->whereCode($moduleCode)->isFree();
	}

	/**
	 * Check if module has new version
	 *
	 * @return bool
	 */
	public function hasUpdates($moduleCode, $version)
	{
		$currentVersion = $this->module->whereCode($moduleCode)->first()->pluck('version');

		if (version_compare($currentVersion, $version))
		{
			return true;
		}
		
		return false;
	}

	/**
	 * Get all published modules (with status = true)
	 *
	 * @return mixed
	 */
	public function published($language_code = 'en')
	{
		return [
			'language_code' => $language_code,
			'modules' => $this->module->published($language_code)->get()
		];
	}

	/**
	 * Get all published modules converted for <select>
	 *
	 * @return array
	 */
	public function publishedForSelect($language_code = 'en')
	{
		$result = [];
		$modules = $this->published()['modules'];

		foreach ($modules as $module)
		{
			$result[$module->code] = $module->information->first()->title;
		}

		return $result;
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
	public function save(array $moduleInfo)
	{
		$module = $this->find($moduleInfo['code'], 'en');

		if ($module)
		{
			$module = $this->module->find($module->id);
			$module->price = empty($moduleInfo['price']) ? 0 : $moduleInfo['price'];
			$module->code = $moduleInfo['code'];
			$module->version = $moduleInfo['version'];
			$module->status = empty($moduleInfo['status']) ? 0 : 1;
			return $module->save();
		}

		$this->module->code = $moduleInfo['code'];
		$this->module->version = $moduleInfo['version'];
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

	/**
	 * Save module images
	 *
	 * @return void
	 */
	public function saveImages($moduleCode, $images)
	{
		if (empty($images)) return false;

		foreach ($images as $image)
		{
			if (empty($image)) continue;

			$image->move(
				base_path("public/resources/{$moduleCode}"), 
				$image->getClientOriginalName()
			);
		}
	}

	/**
	 * Will remove module images by their path
	 *
	 * @return void
	 */
	public function removeImages($moduleCode, $imagesToBeRemoved)
	{
		foreach ($imagesToBeRemoved as $image)
		{
			$this->file->delete(base_path($image));
		}
	}

	/**
	 * Get module images
	 *
	 * @return array
	 */
	public function getImages($moduleCode)
	{
		if ( ! file_exists($path = base_path("public/resources/{$moduleCode}")))
		{
			return [];
		}

		$result = [];
		$images = Finder::create()->in($path)->files();

		foreach ($images as $image)
		{
			$result[] = "/public/resources/{$moduleCode}/{$image->getRelativePathname()}";
		}

		return $result;
	}

}