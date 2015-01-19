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

	public function __construct(ModuleManager $moduleManager)
	{
		$this->moduleManager = $moduleManager;
	}

	public function index()
	{
		return 'list of modules';
	}

	public function publish_form()
	{
		return View::make('module/publish');
	}

	public function publish()
	{
		$zip = Input::file('module')->getPathname();

		$this->moduleManager->store($zip);
	}


}