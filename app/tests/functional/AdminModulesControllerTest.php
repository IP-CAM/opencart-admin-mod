<?php 

class AdminModulesControllerTest extends TestCase
{

	public function setUp()
	{
		parent::setUp();

		Route::enableFilters();
	}
	
	/**
	 * @test
	 */
	public function it_redirects_if_user_is_not_admin()
	{
		$user = new User([ 'is_admin' => false ]);

		Auth::shouldReceive('check')->andReturn(false);
		Auth::shouldReceive('user')->andReturn($user);
		
		$this->call('get', 'admin');

		$this->assertRedirectedToRoute('admin.login');
	}

	/**
	 * @test
	 */
	public function it_shows_admin_page_for_admins_only()
	{
		$user = new User([ 'is_admin' => true ]);

		Auth::shouldReceive('check')->andReturn(true);
		Auth::shouldReceive('user')->andReturn($user);
		
		$this->call('get', 'admin');

		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_shows_login_form_to_guest()
	{
		Auth::shouldReceive('check')->andReturn(false);
		
		$this->call('get', 'admin/login');

		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_redirects_logged_user_from_login_form()
	{
		Auth::shouldReceive('check')->andReturn(true);
		
		$this->call('get', 'admin/login');

		$this->assertRedirectedTo('/');
	}

	/**
	 * @test
	 */
	public function it_redirects_user_after_he_logged_in()
	{
		$credentials = [
			'login' => 'admin',
			'password' => 'pass'
		];
		
		Auth::shouldReceive('check')->andReturn(false);
		Auth::shouldReceive('attempt')->andReturn(true);
		
		$this->call('post', 'admin/login', $credentials);

		$this->assertRedirectedToRoute('admin.home');
	}

	/**
	 * @test
	 */
	public function it_redirects_user_back_if_authorization_failed()
	{
		$credentials = [
			'login' => 'admin',
			'password' => 'pass'
		];
		
		Auth::shouldReceive('check')->andReturn(false);
		Auth::shouldReceive('attempt')->andReturn(false);
		
		$this->call('post', 'admin/login', $credentials);

		$this->assertRedirectedToRoute('admin.login');
	}

	/**
	 * @test
	 */
	public function it_redirects_user_back_if_validation_failed()
	{
		Auth::shouldReceive('check')->andReturn(false);
		
		$this->call('post', 'admin/login', ['password' => 'pass']);

		$this->assertRedirectedToRoute('admin.login');
	}

	/**
	 * @test
	 */
	public function it_logs_out_user()
	{
		Route::disableFilters();

		$user = new User([ 'id' => 1 ]);
		Auth::shouldReceive('logout')->andReturn(true);
		Auth::shouldReceive('user')->andReturn($user);

		$this->call('get', 'admin/logout');

		$this->assertRedirectedTo('/');
	}
	
}