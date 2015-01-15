<?php 

use Blocks\Repositories\ModuleRepository;

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
	public function it_should_move_module_to_temporary_directory()
	{
		$demoModuleFile = base_path() . '/app/tests/testing-module.zip';
		$updaloadedModulePath = base_path() . '/tmp/uploaded-module';

		$this->_moduleRepository->handleUploadedModule($demoModuleFile);

		$this->assertFileExists($updaloadedModulePath);
	}


	/**
	 * @expectedException exception
	 * @test
	 */
	public function it_should_throw_exception_if_uploaded_module_not_exists()
	{
		$demoModuleFile = uniqid() . 'not-existing-url';

		$this->_moduleRepository->handleUploadedModule($demoModuleFile);
	}

	/**
	 * @test
	 */
	public function it_should_return_uploaded_module_json_information()
	{
		$updaloadedModulePath = base_path() . '/tmp/uploaded-module/module.json';

		$result = $this->_moduleRepository->readUploadedModule($updaloadedModulePath);

		$this->assertEquals('demo2', $result->name);
	}

	/**
	 * @expectedException exception
	 * @test
	 */
	public function it_should_throw_exception_if_uploaded_module_json_not_exists()
	{
		$updaloadedModulePath = base_path() . '/tmp/uploaded-module/module.json';

		// Remove module.json
		File::delete($updaloadedModulePath);

		$this->_moduleRepository->readUploadedModule($updaloadedModulePath);
	}

	/**
	 * @test
	 */
	public function it_should_update_module_zip_file_and_module_info_in_database()
	{
		$moduleListPath = app_path() . '/tests/testing-modules';
		$demoModuleFile = base_path() . '/app/tests/testing-module.zip';

		$this->_moduleRepository->handleUploadedModule($demoModuleFile);
		$json = $this->_moduleRepository->readUploadedModule();

		$this->storeModule($demoModuleFile, $json);

		$this->assertFileExists($moduleListPath . '/testing-module.zip');
	}

	
}