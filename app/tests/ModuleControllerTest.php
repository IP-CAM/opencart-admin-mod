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
		$secret = "testing-secret";

		$this->call('post', 'module/publish', ['secret' => $secret], ['module' => $zip]);

		$this->assertRedirectedTo('/');
	}

	/**
	 * @test
	 */
	public function it_return_401_error_if_publish_module_with_wrong_secret_key()
	{
		$secret = 'wrong-secret-key';

		$this->call('post', 'module/publish', ['secret' => $secret]);

		$this->assertResponseStatus(401);
	}

	/**
	 * @test
	 */
	public function it_shows_form_to_upload_new_module()
	{
		$this->call('get', 'module/publish');

		$this->assertResponseStatus(200);
	}
	
}