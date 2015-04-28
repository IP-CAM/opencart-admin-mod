<?php 

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Blocks\Models\Module;

class ModuleControllerTest extends TestCase
{

	protected $moduleRepository;

	public function setUp()
	{
		parent::setUp();

		$this->moduleRepository = App::make('Blocks\Repositories\ModuleRepository');
		$this->keyRepository = App::make('Blocks\Repositories\KeyRepository');

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
	public function it_shows_module_information_in_jsonp()
	{
		$moduleCode = Module::first()->pluck('code');
		
		$this->call('get', "/module/{$moduleCode}.json");

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

		$this->moduleHasLanguages('test-module', ['ua', 'en', 'ru']);
		$this->moduleHasCorrectStatus('test-module', 1);

		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	function it_triggers_module_download_and_dont_store_anythink_in_database_if_module_is_paied()
	{
		$moduleCode = 'test-download-module';
		$domain = 'test-domain.com';

		Module::whereCode($moduleCode)->update(['price' => '999']);

		File::copy(
			base_path("app/tests/resources/test-module.zip"),
			base_path("public/modules/{$moduleCode}.zip")
		);

		$this->call('get', "/module/{$moduleCode}.zip");
		$keyInfo = $this->keyRepository->byModuleAndDomain($moduleCode, $domain);
		$allKeys = $this->keyRepository->all()->toArray();

		$this->assertCount(0, $allKeys);
		$this->assertNull($keyInfo);
		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	function it_triggers_module_download_and_stores_domain_to_module_relation_in_database_if_module_is_free()
	{
		$moduleCode = 'test-download-module';
		$domain = 'example.com';

		Module::whereCode($moduleCode)->update(['price' => '0']);

		File::copy(
			base_path("app/tests/resources/test-module.zip"),
			base_path("public/modules/{$moduleCode}.zip")
		);

		$this->call('get', "/module/{$moduleCode}.zip", ['domain' => $domain]);
		$keyInfo = $this->keyRepository->byModuleAndDomain($moduleCode, $domain);
		$allKeys = $this->keyRepository->all()->toArray();

		$this->assertCount(1, $allKeys);
		$this->assertNotNull($keyInfo);
		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_checks_module_version_and_has_updates()
	{
		// Arrange
		$moduleCode = 'test-download-module';
		Module::whereCode($moduleCode)->update(['version' => '0.2.1']);

		// Act
		$query = $this->call('get', 'module/version', [
			'module' => $moduleCode,
			'version' => '0.0.1'
		]);

		$json = json_decode($query->getContent());

		$this->assertTrue($json->status);
		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_checks_module_version_and_does_not_has_updates()
	{
		// Arrange
		$moduleCode = 'test-download-module';
		Module::whereCode($moduleCode)->update(['version' => '0.2.0']);

		// Act
		$query = $this->call('get', 'module/version', [
			'module' => $moduleCode,
			'version' => '0.2.1'
		]);

		$json = json_decode($query->getContent());

		$this->assertTrue($json->status);
		$this->assertResponseStatus(200);
	}

	/**
	 * Check if module has languages
	 *
	 * @return void
	 */
	protected function moduleHasLanguages($moduleCode, $languageCodes)
	{
		// Arrange
		$moduleId = Module::getIdByCode($moduleCode);
		$languages = $this->moduleRepository->getAvalibleLanguages($moduleId);

		// Assert
		$this->assertArrayHasKey('ua', $languages, 'I cant find UA language in module');
		$this->assertArrayHasKey('ru', $languages, 'I cant find RU language in module');
		$this->assertArrayHasKey('en', $languages, 'I cant find EN language in module');

		$this->assertNotNull($languages['ua'], 'I cant find UA language in module');
		$this->assertNotNull($languages['ru'], 'I cant find RU language in module');
		$this->assertNotNull($languages['en'], 'I cant find EN language in module');
	}

	/**
	 * Check if module has correct `status` in database
	 *
	 * @return void
	 */
	protected function moduleHasCorrectStatus($moduleCode, $status)
	{
		$moduleInfo = $this->moduleRepository->find($moduleCode, 'en');
		
		$this->assertEquals($status, $moduleInfo->status);
	}
	
}