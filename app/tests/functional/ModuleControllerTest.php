<?php 

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ModuleControllerTest extends TestCase
{

	protected $moduleRepository;

	public function setUp()
	{
		parent::setUp();

		$this->moduleRepository = App::make('Blocks\Repositories\ModuleRepository');

		File::deleteDirectory(base_path('tmp/uploaded-module'));
	}
	
	/**
	 * @test
	 */
	public function it_opens_all_modules_page()
	{
		$view = 'module.index';
        $this->registerNestedView($view);
        
        $this->call('GET', 'module');
        
        // Check if view has needle data
        $this->assertNestedViewHas($view, 'modules');
	}

	/**
	 * @test
	 */
	public function it_returns_all_published_modules_in_jsonp()
	{
		$this->call('get', '/module/all.json');

		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_returns_modules_with_different_languages()
	{
		// eng
		$this->call('get', 'module');

		// eng
		$this->call('get', 'module', ['lang' => 'en']);

		// rus
		$this->call('get', 'module', ['lang' => 'ru']);
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
	 * 
	 * @expectedException Blocks\Exceptions\InvalidSecretException
	 */
	public function it_throws_exception_if_secret_key_is_bad()
	{
		// cleanup
		\Illuminate\Support\Facades\File::deleteDirectory(base_path('tmp/uploaded-module'));
		\Illuminate\Support\Facades\File::delete(base_path('public/modules/test-module.zip'));

		// Given
		$zip = app_path('tests/resources/test-module.zip');

		// When
		$this->call('post', 'module/publish', ['secret' => 'wrong-secret-key'], [
			'module' => new UploadedFile($zip, 'module')
		]);
	}

	/**
	 * @test
	 */
	public function it_stores_module_from_post_request()
	{
		// cleanup
		\Illuminate\Support\Facades\File::deleteDirectory(base_path('tmp/uploaded-module'));
		\Illuminate\Support\Facades\File::delete(base_path('public/modules/test-module.zip'));

		// Given
		$zip = app_path('tests/resources/test-module.zip');

		// When
		$this->call('post', 'module/publish', ['secret' => 'testing-secret'], [
			'module' => new UploadedFile($zip, 'module')
		]);

		// Then
		$this->assertFileExists(base_path('tmp/uploaded-module'));
		$this->assertFileExists(base_path('public/modules/test-module.zip'));

		$this->assertNotNull($this->moduleRepository->find('test-module', 'en'));

		$this->assertResponseStatus(200);
	}
	
}