<?php namespace Blocks\Controllers;

use Blocks\Services\Secret;
use Blocks\Repositories\ModuleRepository;
use Blocks\Services\ModuleManager;
use View;
use Input;
use Redirect;
use Response;

class ModuleController extends BaseController
{

	protected $moduleManager;
	protected $moduleRepository;

	public function __construct(ModuleManager $moduleManager, ModuleRepository $moduleRepository)
	{
		$this->moduleManager = $moduleManager;
		$this->moduleRepository = $moduleRepository;
	}

	public function index()
	{
		$modules = $this->moduleRepository->published();

		$this->layout->content = View::make('module.index', compact('modules'));
	}

	public function publish_form()
	{
		$this->layout->content = View::make('module/publish');
	}

	public function publish()
	{
		$zip = Input::file('module')->getPathname();

		$this->moduleManager->store($zip);

		return Response::make('Module uploaded successfully!', 200);
	}


}