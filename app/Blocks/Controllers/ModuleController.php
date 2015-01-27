<?php namespace Blocks\Controllers;

use Blocks\Services\Secret;
use Blocks\Repositories\ModuleRepository;
use Blocks\Services\KeyManager;
use Blocks\Services\ModuleManager;
use Blocks\Exceptions\InvalidSecretException;
use Blocks\Exceptions\ModuleZipNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use View;
use Input;
use Redirect;
use Response;

class ModuleController extends BaseController
{

	protected $moduleManager;
	protected $moduleRepository;
	protected $keyManager;
	protected $secretService;

	public function __construct(
		ModuleManager $moduleManager, 
		ModuleRepository $moduleRepository, 
		KeyManager $keyManager, 
		Secret $secretService)
	{
		$this->moduleManager = $moduleManager;
		$this->moduleRepository = $moduleRepository;
		$this->keyManager = $keyManager;
		$this->secretService = $secretService;
	}

	public function index()
	{
		$language_code = Input::get('language_code', 'en');
		$modules = $this->moduleRepository->published($language_code)['modules'];
		
		$this->layout->content = View::make('module.index', compact('modules'));
	}

	public function publish_form()
	{
		$this->layout->content = View::make('module/publish');
	}

	public function publish()
	{
		if ( ! $this->checkSecret())
		{
			throw new InvalidSecretException("Invalid secret code");
		}

		$zip = Input::file('module')->getPathname();
		
		$this->moduleManager->store($zip);

		return Response::make('Module uploaded successfully!', 200);
	}

	/**
	 * Checks secret code
	 *
	 * @return bool
	 */
	protected function checkSecret()
	{
		return $this->secretService->check(Input::get('secret'));
	}

	/**
	 * Show a list of published modules in jsonp
	 *
	 * @return jsonp
	 */
	public function all_json()
	{
		$language_code = Input::get('language_code', 'en');

		return $this->moduleRepository->published($language_code);
	}

	/**
	 * Show specific module information in jsonp format
	 *
	 * @return jsonp
	 */
	public function find_json($moduleCode)
	{
		$module = $this->moduleRepository->find($moduleCode, Input::get('language_code', 'en'));
		$module->zip = $this->moduleManager->find($moduleCode);

		return $module;
	}

	/**
	 * Download module zip
	 *
	 * @return Response
	 */
	public function download($moduleCode)
	{
		$key = $this->keyManager->create($moduleCode, 'test-domain.com');
		$zip = $this->moduleManager->find($moduleCode);
		
		if ( ! $zip)
		{
			throw new ModuleZipNotFoundException("Module {$moduleCode} zip not found");
		}

	    return Response::download(new UploadedFile($zip, 'module'));
	}

}