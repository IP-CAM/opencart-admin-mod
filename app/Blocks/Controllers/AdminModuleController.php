<?php namespace Blocks\Controllers;

use View;
use User;
use Validator;
use Input;
use Redirect;
use Auth;

class AdminModuleController extends BaseController
{
	
	function __construct()
	{
	}

	public function home()
	{
		$this->layout->content = View::make('admin.home');
	}

	/**
	 * Show login form
	 *
	 * @return Response
	 */
	public function login()
	{
		$this->layout->content = View::make('user.login');
	}

	/**
	 * Handle user authorization
	 *
	 * @return void
	 */
	public function login_post()
	{
		$v = Validator::make(Input::all(), User::$rules);

		if ($v->fails()) return Redirect::route('admin.login')->withInput()->withErrors($v);
		
		$credentials = [
			'login' => Input::get('login'),
			'password' => Input::get('password'),
		];

		if ( ! Auth::attempt($credentials))
		{
			return Redirect::route('admin.login')->withInput()->with('auth_fail', true);
		}

		return Redirect::route('admin.home');
	}

	/**
	 * Logs user out
	 *
	 * @return Response
	 */
	public function logout()
	{
		Auth::logout(Auth::user()->id);

		return Redirect::to('/');
	}

}