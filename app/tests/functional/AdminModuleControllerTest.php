<?php 

use Blocks\Models\Module;

class AdminModuleControllerTest extends TestCase
{
	
	/**
	 * @test
	 */
	public function it_shows_module_list()
	{
		$this->call('get', 'admin/module');

		$this->assertResponseStatus('200');
	}

	/**
	 * @test
	 */
	public function it_opens_page_to_edit_module()
	{
		$moduleCode = Module::first()->pluck('code');
		$this->call('get', "admin/module/{$moduleCode}/edit");

		$this->assertResponseStatus(200);
	}
	
}