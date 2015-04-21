<?php 

class KeyRepositoryTest extends TestCase
{

	protected $keyRepository;

	function setUp()
	{
		parent::setUp();

		$this->keyRepository = App::make('Blocks\Repositories\KeyRepository');
	}
	
	/**
	 * @test
	 */
	public function it_can_find_key_by_module_code()
	{
		
	}
	
}