<?php namespace Blocks\Controllers;

use Blocks\Services\Secret;
use Blocks\Repositories\ModuleRepository;
use View;
use Input;
use Redirect;
use Response;

class ModuleController extends BaseController
{

	protected $_moduleRepository;
	protected $_secretService;
	
	function __construct(ModuleRepository $moduleRepository, Secret $secretService)
	{
		$this->_moduleRepository = $moduleRepository;
		$this->_secretService = $secretService;
	}

	public function index()
	{
		$modules = $this->_moduleRepository->all();

		return View::make('module/index', compact('modules'));
	}

	/**
	 * Store module info via console (blocks module:publish)
	 *
	 * @return void
	 */
	public function publish()
	{
		if ( ! $this->_secretService->check(Input::get('secret')))
		{
			return Response::make('', 401);
		}

		$zip = Input::file('module')->getRealPath();

		$json = $this->_moduleRepository->handleUploadedZip($zip);
		$this->_moduleRepository->store($zip, $json);

		return Redirect::to('/');
	}

	/**
	 * Show form to upload new module
	 *
	 * @return void
	 */
	public function publish_form()
	{
		return View::make('module/publish');
	}


}