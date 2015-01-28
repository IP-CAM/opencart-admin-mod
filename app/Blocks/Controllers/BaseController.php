<?php namespace Blocks\Controllers;

use Illuminate\Routing\Controller;
use View;
use Input;

class BaseController extends Controller
{

	protected $layout = 'default';

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}