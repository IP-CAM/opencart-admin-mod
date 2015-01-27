<?php 

use Blocks\Models\Module;

class AdminModuleControllerTest extends TestCase
{

	protected $moduleRepository;
	
	function setUp()
	{
		parent::setUp();

		$this->moduleRepository = App::make('Blocks\Repositories\ModuleRepository');
	}
	
	/**
	 * @test
	 */
	public function it_shows_module_list()
	{
		$this->call('get', 'admin/module');

		$this->assertResponseStatus('200');
	}

	/**
	 * @test
	 */
	public function it_opens_page_to_edit_module()
	{
		// Arrange
		$view = 'admin.module.edit';
		$this->registerNestedView($view);
		
		// Act
		$moduleCode = Module::first()->pluck('code');
		$this->call('get', "admin/module/{$moduleCode}/edit");
		
		// Assert
		$this->assertNestedViewHas($view, 'module');
		$this->assertNestedViewHas($view, 'zip');
		$this->assertNestedViewHas($view, 'avalibleLanguages');
		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_stores_module_info_with_multilang()
	{
		$input = [
			'languages' => [
				'en' => [
					'title' => 'title eng',
					'description' => 'Laudantium quisquam laudantium assumenda delectus voluptatem nam voluptatem totam sit pariatur culpa explicabo quia.',
				],
				'ru' => [
					'title' => 'title rus',
					'description' => 'Sit reprehenderit commodi distinctio deleniti quod molestiae quia quia qui beatae nemo quisquam culpa.',
				],
				'ua' => [
					'title' => 'Title ukr',
					'description' => 'Qui quia nobis sint odit quidem labore quia necessitatibus minus odio facilis animi aut voluptatem debitis.',
				],
			],
			'price' => 999,
			'version' => '2.0.0',
			'status' => 1
		];
		
		$moduleCode = Module::first()->pluck('code');
		$moduleId = Module::first()->pluck('id');
		
		$this->call('put', "admin/module/{$moduleCode}", $input);
		$moduleInfo = $this->moduleRepository->find($moduleCode, 'en');
		$moduleLangs = $this->moduleRepository->getAvalibleLanguages($moduleId);
		
		$this->assertEquals($moduleLangs['en']->title, $input['languages']['en']['title']);
		$this->assertEquals($moduleLangs['ru']->title, $input['languages']['ru']['title']);
		$this->assertEquals($moduleLangs['ua']->title, $input['languages']['ua']['title']);
		
		$this->assertEquals($moduleInfo->price, $input['price']);
		$this->assertEquals($moduleInfo->version, $input['version']);
		$this->assertEquals($moduleInfo->status, $input['status']);
	}
	
}