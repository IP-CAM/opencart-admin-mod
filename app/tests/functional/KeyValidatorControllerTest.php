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
	public function it_checks_if_module_is_related_to_specific_domain()
	{
		// Arrange
		$this->keyRepository->store('test-download-module', 'example.com');

		// Act
		$request = $this->call('get', 'key/validate', [
			'module' => 'test-download-module',
			'domain' => 'example.com'
		]);

		$json = json_decode($request->getContent());

		// Assert
		$this->assertTrue($json->status);
		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_fails_check_if_module_is_not_related_to_domain()
	{
		// Act
		$request = $this->call('get', 'key/validate', [
			'module' => 'test-download-module',
			'domain' => 'bad-domain.com'
		]);

		$json = json_decode($request->getContent());

		// Assert
		$this->assertFalse($json->status);
		$this->assertResponseStatus(200);
	}
	
}