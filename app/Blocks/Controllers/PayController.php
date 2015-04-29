<?php namespace Blocks\Controllers;

use Blocks\Repositories\ModuleRepository;
use Blocks\Billing\Interkassa;
use View;
use Input;
use Response;
use File;


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
		File::put(base_path('/success-log.txt'), json_encode(Input::all()));

		return '+';
	}

	public function fail()
	{
		File::put(base_path('/fail-log.txt'), json_encode(Input::all()));

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