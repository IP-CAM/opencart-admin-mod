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
		$moduleInfo = $moduleInfo->describe('test-module');

		// First we will create new module
		$moduleInfo->override('version', '1.0.0');
		$this->repository->save($moduleInfo);
		$module = $this->repository->find($moduleInfo->getName(), 'en');

		$this->assertEquals($module->code, 'test-module');
	}

	/**
	 * @test
	 */
	public function it_updates_module_info_in_db()
	{
		// Arrange
		$moduleInfo = App::make('Blocks\Helpers\ModuleJson');
		$moduleInfo = $moduleInfo->describe('test-module');
		
		// Act
		$moduleInfo->override('version', '1.0.0');
		$this->repository->save($moduleInfo);
		
		$moduleInfo->override('version', '2.0.0');
		$this->repository->save($moduleInfo);

		$moduleInfo->override('version', '3.0.0');
		$this->repository->save($moduleInfo);
		
		// Assert
		$moduleCode = $moduleInfo->getName();
		$module = $this->repository->find($moduleCode, 'en');
		$totalModules = Module::whereCode($moduleCode)->count();

		$this->assertEquals($module->version, '3.0.0');
		$this->assertEquals($totalModules, 1);
	}

	/**
	 * @test
	 */
	public function it_fetches_published_modules()
	{
		// Arrange
		$moduleInfo = App::make('Blocks\Helpers\ModuleJson');
		$moduleInfo = $moduleInfo->describe('test-module');
		$moduleInfo->override('name', 'hello');
		$this->repository->save($moduleInfo);

		// Act
		$modules = $this->repository->published('en');

		$result = array_filter($modules['modules']->toArray(), function($val)
		{
			return ! $val['status'];
		});

		// Assert
		$this->assertCount(0, $result);
	}

	/**
	 * @test
	 */
	public function it_fetches_modules_with_different_languages()
	{
		$result = $this->repository->published('en');

		$this->assertArrayHasKey('language_code', $result);
		$this->assertArrayHasKey('modules', $result);
	}

	/**
	 * @test
	 */
	public function it_show_information_fow_single_module()
	{
		$moduleCode = Module::first()->pluck('code');
		$module = $this->repository->find($moduleCode, 'en')->toArray();

		$this->assertNotNull($module);
		$this->assertArrayHasKey('id', $module);
		$this->assertArrayHasKey('information', $module);
	}

	/**
	 * @test
	 */
	public function it_shows_module_avalible_languages()
	{
		$moduleCode = Module::first()->pluck('code');
		$result = $this->repository->getAvalibleLanguages($moduleCode);

		$this->assertArrayHasKey('en', $result);
		$this->assertArrayHasKey('ru', $result);
		$this->assertArrayHasKey('ua', $result);
	}
	
}