<?php namespace Blocks\Controllers;

use Blocks\Repositories\ModuleRepository;
use Blocks\Services\ModuleManager;
use View;
use User;
use Validator;
use Input;
use Redirect;
use Auth;

class AdminModuleController extends BaseController
{

	protected $moduleRepository;
	protected $moduleManager;
	
	function __construct(ModuleRepository $moduleRepository, ModuleManager $moduleManager)
	{
		$this->moduleRepository = $moduleRepository;
		$this->moduleManager = $moduleManager;
	}

	public function home()
	{
		$this->layout->content = View::make('admin.home');
	}

	/**
	 * Displays a list of all modules
	 *
	 * @return Response
	 */
	public function index()
	{
		$modules = $this->moduleRepository->published('en')['modules'];

		$this->layout->content = View::make('admin.module.index', compact('modules'));
	}

	/**
	 * Displays form to edit module
	 *
	 * @return Response
	 */
	public function edit($moduleCode)
	{
		$module = $this->moduleRepository->find($moduleCode, 'en');
		$avalibleLanguages = $this->moduleRepository->getAvalibleLanguages($module->id);
		$zip = $this->moduleManager->find($moduleCode);
		$images = $this->moduleRepository->getImages($moduleCode);
		
		$this->layout->content = View::make('admin.module.edit')
			->with('module', $module)
			->with('images', $images)
			->with('zip', $zip)
			->with('avalibleLanguages', $avalibleLanguages);
	}

	/**
	 * Updates module information
	 *
	 * @return Response
	 */
	public function update($moduleCode)
	{
		$this->moduleRepository->save([
			'code' => $moduleCode,
			'price' => Input::get('price'),
			'version' => Input::get('version'),
			'status' => Input::get('status')
		]);

		$this->moduleRepository->saveLanguages($moduleCode, Input::get('languages'));
		$this->moduleRepository->saveImages($moduleCode, Input::file('images'));

		return Redirect::route('admin.module.index');
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
	 * @return Response
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