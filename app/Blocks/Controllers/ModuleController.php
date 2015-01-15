<?php namespace Blocks\Controllers;

use Blocks\Repositories\ModuleRepository;
use View;
use Input;

class ModuleController extends BaseController
{

	protected $moduleRepository;
	
	function __construct(ModuleRepository $moduleRepository)
	{
		$this->moduleRepository = $moduleRepository;
	}

	public function index()
	{
		$modules = $this->moduleRepository->all();

		return View::make('module/index', compact('modules'));
	}

	/**
	 * Store module info via console (blocks module:publish)
	 *
	 * @return void
	 */
	public function publish()
	{
		$zip = Input::file('module')->getRealPath();

		$json = $this->moduleRepository->handleUploadedZip($zip);
		$this->moduleRepository->store($zip, $json);
	}


	public function publishfile()
	{
		return View::make('module/publish');
	}


}