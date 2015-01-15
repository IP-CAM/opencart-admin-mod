<?php 

use Blocks\Repositories\ModuleRepository;
use Blocks\Models\Module;

class ModuleRespotisotyTest extends TestCase
{

	protected $_module;
	protected $_moduleRepository;
	
	public function setUp()
	{
		parent::setUp();

		$this->_module = $this->mock('Blocks\Models\Module');
		$this->_moduleRepository = new ModuleRepository($this->_module);
	}
	
	/**
	 * @test
	 */
	public function it_should_move_module_to_temporary_directory_and_read_module_json()
	{
		$demoModuleFile = base_path() . '/app/tests/demo2.zip';
		$updaloadedModulePath = base_path() . '/tmp/uploaded-module';

		$json = $this->_moduleRepository->handleUploadedZip($demoModuleFile);

		$this->assertEquals('demo2', $json->name);
		$this->assertFileExists($updaloadedModulePath);
	}


	/**
	 * @expectedException exception
	 * @test
	 */
	public function it_should_throw_exception_if_uploaded_module_not_exists()
	{
		$demoModuleFile = uniqid() . 'not-existing-url';

		$this->_moduleRepository->handleUploadedZip($demoModuleFile);
	}

	/**
	 * @test
	 */
	public function it_should_update_module_zip_file_and_module_info_in_database()
	{
		// Arrange
		$moduleListPath = base_path() . '/public/modules';
		$demoModuleFile = base_path() . '/app/tests/demo2.zip';

		$demoModule = new Module([
			'id' => '1',
			'code' => 'demo_code',
			'version' => '0.0.1',
			'price' => '100',
			'downloads' => '50'
		]);
		$this->_module->shouldReceive('pluck')->andReturn(1);
		$this->_module->shouldReceive('find', 'where', 'setAttribute')->andReturn($this->_module);
		$this->_module->shouldReceive('first')->andReturn($demoModule);
		$this->_module->shouldReceive('save')->andReturn(true);

		// Act
		$json = $this->_moduleRepository->handleUploadedZip($demoModuleFile);

		$this->_moduleRepository->store($demoModuleFile, $json);

		// Assert
		$this->assertFileExists($moduleListPath . '/demo2.zip');
	}

	
}