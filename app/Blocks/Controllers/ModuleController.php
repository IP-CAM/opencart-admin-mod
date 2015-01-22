<?php namespace Blocks\Controllers;

use Blocks\Services\Secret;
use Blocks\Repositories\ModuleRepository;
use Blocks\Services\ModuleManager;
use Blocks\Exceptions\InvalidSecretException;
use View;
use Input;
use Redirect;
use Response;

class ModuleController extends BaseController
{

	protected $moduleManager;
	protected $moduleRepository;
	protected $secretService;

	public function __construct(ModuleManager $moduleManager, ModuleRepository $moduleRepository, Secret $secretService)
	{
		$this->moduleManager = $moduleManager;
		$this->moduleRepository = $moduleRepository;
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

	public function all_json()
	{
		$language_code = Input::get('language_code', 'en');

		return $this->moduleRepository->published($language_code);
	}

}