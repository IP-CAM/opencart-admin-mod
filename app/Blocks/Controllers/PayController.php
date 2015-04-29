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
		return 'hello with pay method';
	}

	public function success()
	{
		return '+';
	}

	public function fail()
	{
		return '-';
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