<?php namespace Blocks\Controllers;

use Blocks\Repositories\ModuleRepository;
use Blocks\Repositories\KeyRepository;
use Blocks\Billing\Interkassa;
use View;
use Input;
use Response;
use File;


class PayController extends BaseController
{

	protected $moduleRepository;
	protected $keyRepository;
	protected $interkassa;

	public function __construct(
		ModuleRepository $moduleRepository, 
		Interkassa $interkassa, 
		KeyRepository $keyRepository
	)
	{
		$this->moduleRepository = $moduleRepository;
		$this->interkassa = $interkassa;
		$this->keyRepository = $keyRepository;
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
		$step = [];

		$moduleCode = Input::get('ik_x_module_code');
		$domain = Input::get('ik_x_domain');
		$price = Input::get('ik_am');

		// Check if kassa is OK
		if ($this->interkassa->validate(Input::all()))
		{
			$step[] = 'interkassa::validate is ok';

			// Get module info in order to check 
			// payed price with actual module price
			$module = $this->moduleRepository->find($moduleCode);

			$step[] = 'module price is' . $module->price;
			$step[] = 'target price is' . $price;

			if ( ! empty($module) AND $module->price == $price)
			{
				$step[] = 'key repo should store all the stuff';
				$this->keyRepository->store($moduleCode, $domain);
			}
		}

		File::put(base_path('/pay-process-log.txt'), json_encode(Input::all()));
		File::put(base_path('/step-log.txt'), json_encode($step));

		return Response::json([]);
	}

}