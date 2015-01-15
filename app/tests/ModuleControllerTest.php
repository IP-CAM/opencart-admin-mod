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
	public function it_store_module_from_post_request()
	{
		$zip = new \Symfony\Component\HttpFoundation\File\UploadedFile(
			app_path() . '/tests/demo2.zip',
			'demo2.zip'
		);

		$this->call('post', 'module/publish', [], ['module' => $zip]);

		$this->assertResponseStatus(200);
	}
	
}