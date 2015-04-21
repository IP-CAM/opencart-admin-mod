<?php namespace Blocks\Controllers;

use Blocks\Repositories\KeyRepository;
use Input;
use Response;

class KeyValidatorController extends BaseController
{

	protected $keyRepository;

	function __construct(KeyRepository $keyRepository)
	{
		$this->keyRepository = $keyRepository;
	}
	
	/**
	 * Validate key + module + domain
	 *
	 * @return Response
	 */
	public function validate()
	{
		$status = (bool) $this->keyRepository->byModuleAndDomain(
			Input::get('module'), 
			Input::get('domain')
		);

		return Response::json(compact('status'));
	}

}