<?php 

use Blocks\Helpers\ModuleJson;
use Blocks\Models\Module;

class ModuleRepositoryTest extends TestCase
{

	protected $repository;

	public function setUp()
	{
		parent::setUp();

		$this->repository = App::make('Blocks\Repositories\ModuleRepository');
	}
	
	/**
	 * @test
	 */
	public function it_stores_module_info_in_database()
	{
		$moduleInfo = App::make('Blocks\Helpers\ModuleJson');
		$moduleInfo = $moduleInfo->describe('uploaded-module');

		// First we will create new module
		$moduleInfo->override('version', '1.0.0');
		$this->repository->save($moduleInfo);
		$module = $this->repository->find($moduleInfo->getName());

		$this->assertEquals($module->code, 'test-module');
	}

	/**
	 * @test
	 */
	public function it_updates_module_info_in_db()
	{
		// Arrange
		$moduleInfo = App::make('Blocks\Helpers\ModuleJson');
		$moduleInfo = $moduleInfo->describe('uploaded-module');
		
		// Act
		$moduleInfo->override('version', '1.0.0');
		$this->repository->save($moduleInfo);
		
		$moduleInfo->override('version', '2.0.0');
		$this->repository->save($moduleInfo);

		$moduleInfo->override('version', '3.0.0');
		$this->repository->save($moduleInfo);
		
		// Assert
		$moduleCode = $moduleInfo->getName();
		$module = $this->repository->find($moduleCode);
		$totalModules = Module::whereCode($moduleCode)->count();

		$this->assertEquals($module->version, '3.0.0');
		$this->assertEquals($totalModules, 1);
	}
	
}