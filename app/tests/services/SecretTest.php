<?php 


use Blocks\Services\Secret;

class SecretTest extends TestCase
{

	protected $_secretService;
	
	public function setUp()
	{
		parent::setUp();

		$this->_secretService = new Secret;
	}
	
	/**
	 * @test
	 */
	public function it_can_validate_secret_keys()
	{
		$secret = 'test-secret';

		$result = $this->_secretService->check('test-secret');

		$this->assertFalse($result);
	}
	
}