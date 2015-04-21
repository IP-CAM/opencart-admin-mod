<?php namespace Blocks\Controllers;

use Blocks\Repositories\ModuleRepository;
use Blocks\Billing\Interkassa;
use View;
use Input;
use Response;

class PayController extends BaseController
{

	protected $moduleRepository;
	protected $interkassa;

	public function __construct(ModuleRepository $moduleRepository, Interkassa $interkassa)
	{
		$this->moduleRepository = $moduleRepository;
		$this->interkassa = $interkassa;
	}
	
	/**
	 * Show form to create new payment
	 *
	 * @return Response
	 */
	public function index()
	{
		$moduleCode = Input::get('module');
		$domain = Input::get('domain', '');

		$module = $this->moduleRepository->find($moduleCode, 'en');
		$list = $this->moduleRepository->publishedForSelect();

		$this->layout->content = View::make('pay.index')
			->with('modules', $list)
			->with('module', $module)
			->with('domain', $domain);
	}

	/**
	 * Process payment operation
	 *
	 * @return Response
	 */
	public function pay()
	{
		$this->interkassa->validate(Input::all());

		return Response::json([]);
	}

}