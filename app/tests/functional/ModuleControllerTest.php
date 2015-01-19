<?php 

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ModuleControllerTest extends TestCase
{

	public function setUp()
	{
		parent::setUp();

		File::deleteDirectory(base_path('tmp/uploaded-module'));
	}
	
	/**
	 * @test
	 */
	public function it_opens_all_modules_page()
	{
		$this->call('get', 'module');

		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_show_form_to_upload_new_module()
	{
		$this->call('get', 'module/publish');

		$this->assertResponseStatus('200');
	}

	/**
	 * @test
	 */
	public function it_stores_module_from_post_request()
	{
		// cleanup
		\Illuminate\Support\Facades\File::deleteDirectory(base_path('tmp/uploaded-module'));
		\Illuminate\Support\Facades\File::delete(base_path('public/modules/demo2.zip'));

		// Given
		$zip = app_path('tests/resources/demo2.zip');

		// When
		$this->call('post', 'module/publish', [], [
			'module' => new UploadedFile($zip, 'module')
		]);

		// Then
		$this->assertFileExists(base_path('tmp/uploaded-module'));
		$this->assertFileExists(base_path('public/modules/demo2.zip'));

		$this->assertResponseStatus(200);
	}
	
}