<?php 

class ModuleControllerTest extends TestCase
{
	
	/**
	 * @test
	 */
	public function it_show_all_modules()
	{
		$this->call('get', 'module');

		$this->assertViewHas('modules');
		$this->assertResponseStatus(200);
	}


	/**
	 * @test
	 */
	public function it_store_module_post_info()
	{
		// $file = file_get_contents('test-module.zip');

		// $this->call('post', 'module/publish', [], $file);

		// $this->assertResponseStatus(200);
	}
	
}