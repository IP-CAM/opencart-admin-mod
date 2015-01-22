<?php namespace Blocks\Controllers;

use Blocks\Repositories\ModuleRepository;
use View;
use User;
use Validator;
use Input;
use Redirect;
use Auth;

class AdminModuleController extends BaseController
{

	protected $moduleRepository;
	
	function __construct(ModuleRepository $moduleRepository)
	{
		$this->moduleRepository = $moduleRepository;
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

	public function index()
	{
		$modules = $this->moduleRepository->published('en')['modules'];

		$this->layout->content = View::make('admin.module.index', compact('modules'));
	}

	public function edit($moduleCode)
	{
		$module = $this->moduleRepository->find($moduleCode, 'en');
		$avalibleLanguages = $this->moduleRepository->getAvalibleLanguages($module->id);
		
		$this->layout->content = View::make('admin.module.edit')
			->with('module', $module)
			->with('avalibleLanguages', $avalibleLanguages);
	}

	public function update($moduleCode)
	{
		$this->moduleRepository->saveLanguages($moduleCode, Input::get('languages'));

		return Redirect::route('admin.module.index');
	}

}