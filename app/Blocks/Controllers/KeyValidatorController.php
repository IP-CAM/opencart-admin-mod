<?php namespace Blocks\Controllers;

use Blocks\Services\KeyManager;
use Input;
use Response;

class KeyValidatorController extends BaseController
{

	protected $keyManager;

	function __construct(KeyManager $keyManager)
	{
		$this->keyManager = $keyManager;
	}
	
	/**
	 * Validate key + module + domain
	 *
	 * @return Response
	 */
	public function validate()
	{
		$status = $this->keyManager->validate(
			Input::get('key'),
			Input::get('module'),
			Input::get('domain')
		);

		return Response::json(['status' => $status]);
	}

}