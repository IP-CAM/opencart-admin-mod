<?php 

class KeyValidatorControllerTest extends TestCase
{

	protected $keyRepository;

	public function setUp()
	{
		parent::setUp();

		$this->keyRepository = App::make('Blocks\Repositories\KeyRepository');
	}
	
	/**
	 * @test
	 */
	public function it_validates_module_key_with_domain()
	{
		$key = 'random-key';
		$module = 'test-download-module';
		$domain = 'domain.com';

		$this->keyRepository->store($key, $module, $domain);

		// Existing module
		$request = $this->call('get', 'key/validate', [
			'key' => $key,
			'module' => $module,
			'domain' => $domain
		]);

		$content = json_decode($request->getContent());
		$this->assertTrue($content->status);

		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_fails_to_validate_bad_module_key()
	{
		$key = 'random-key';
		$module = 'test-download-module';
		$domain = 'domain.com';

		$this->keyRepository->store($key, $module, $domain);

		// Bad module key
		$request = $this->call('get', 'key/validate', [
			'key' => 'bad-key',
			'module' => $module,
			'domain' => $domain
		]);

		$content = json_decode($request->getContent());
		$this->assertFalse($content->status);

		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_fails_to_validate_bad_module_code()
	{
		$key = 'random-key';
		$module = 'test-download-module';
		$domain = 'domain.com';

		$this->keyRepository->store($key, $module, $domain);

		// Bad module key
		$request = $this->call('get', 'key/validate', [
			'key' => $key,
			'module' => 'bad-module',
			'domain' => $domain
		]);

		$content = json_decode($request->getContent());
		$this->assertFalse($content->status);

		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_fails_to_validate_bad_domain_to_module()
	{
		$key = 'random-key';
		$module = 'test-download-module';
		$domain = 'domain.com';

		$this->keyRepository->store($key, $module, $domain);

		// Bad module key
		$request = $this->call('get', 'key/validate', [
			'key' => $key,
			'module' => $module,
			'domain' => 'bad-domain'
		]);

		$content = json_decode($request->getContent());
		$this->assertFalse($content->status);

		$this->assertResponseStatus(200);
	}
	
}