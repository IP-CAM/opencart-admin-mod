<?php 

use Blocks\Models\Module;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
		$moduleCode = $this->getFirstModule()->code;
		$this->createModuleImage($moduleCode, 3);

		// Act
		$this->call('get', "admin/module/{$moduleCode}/edit");
		
		// Assert
		$this->assertNestedViewHas($view, 'module');
		$this->assertNestedViewHas($view, 'images');
		$this->assertNestedViewHas($view, 'zip');
		$this->assertNestedViewHas($view, 'avalibleLanguages');
		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_stores_module_info_with_multilang()
	{
		$input = $this->getModuleDummyData();
		
		$moduleCode = $this->getFirstModule()->code;
		$moduleId = $this->getFirstModule()->id;

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

	/**
	 * @test
	 */
	public function it_stores_module_images()
	{
		$input = $this->getModuleDummyData();

		File::copy(app_path('tests/resources/images/dummy.png'), app_path('tests/resources/images/random-uiohsakf.png'));
		File::copy(app_path('tests/resources/images/dummy.png'), app_path('tests/resources/images/random-82713d.png'));
		File::copy(app_path('tests/resources/images/dummy.png'), app_path('tests/resources/images/random-k0962kl.png'));

		$images = [
			new UploadedFile(app_path('tests/resources/images/random-uiohsakf.png'), 'random-uiohsakf.png'),
			new UploadedFile(app_path('tests/resources/images/random-82713d.png'), 'random-82713d.png'),
			new UploadedFile(app_path('tests/resources/images/random-k0962kl.png'), 'random-k0962kl.png'),
		];

		$moduleCode = $this->getFirstModule()->code;
		$moduleId = $this->getFirstModule()->id;
		
		$this->call('put', "admin/module/{$moduleCode}", $input, ['images' => $images]);

		$this->assertFileExists(base_path("public/resources/{$moduleCode}/1.png"));
		$this->assertFileExists(base_path("public/resources/{$moduleCode}/2.png"));
		$this->assertFileExists(base_path("public/resources/{$moduleCode}/3.png"));

		File::deleteDirectory(base_path("public/resources/{$moduleCode}"));
	}

	/**
	 * @test
	 */
	public function it_removes_module_images()
	{
		$input = $this->getModuleDummyData();
		$moduleCode = $this->getFirstModule()->code;
		$moduleId = $this->getFirstModule()->id;

		File::makeDirectory(base_path("public/resources/{$moduleCode}"));
		File::copy(app_path('tests/resources/images/dummy.png'), base_path("public/resources/{$moduleCode}/1.png"));
		File::copy(app_path('tests/resources/images/dummy.png'), base_path("public/resources/{$moduleCode}/2.png"));
		File::copy(app_path('tests/resources/images/dummy.png'), base_path("public/resources/{$moduleCode}/3.png"));
		
		// Create removable images
		$input['remove_image'] = [
			"public/resources/{$moduleCode}/1.png",
			"public/resources/{$moduleCode}/2.png",
		];

		// Act
		$this->call('put', "admin/module/{$moduleCode}", $input);
		
		// Assert
		$this->assertFileNotExists(base_path("public/resources/{$moduleCode}/1.png"));
		$this->assertFileNotExists(base_path("public/resources/{$moduleCode}/2.png"));
		$this->assertFileExists(base_path("public/resources/{$moduleCode}/3.png"));

		File::deleteDirectory(base_path("public/resources/{$moduleCode}"));
	}

	/**
	 * @test
	 */
	public function it_changes_module_logo()
	{
		$input = $this->getModuleDummyData();
		$moduleCode = $this->getFirstModule()->code;
		$moduleId = $this->getFirstModule()->id;

		File::makeDirectory(base_path("public/resources/{$moduleCode}"));
		File::copy(app_path('tests/resources/images/dummy.png'), base_path("public/resources/{$moduleCode}/1.png"));
		File::copy(app_path('tests/resources/images/dummy.png'), base_path("public/resources/{$moduleCode}/2.png"));
		File::copy(app_path('tests/resources/images/dummy.png'), base_path("public/resources/{$moduleCode}/3.png"));
		
		// Set module logo image
		$input['is_logo'] = "public/resources/{$moduleCode}/2.png";

		// Act
		$this->call('put', "admin/module/{$moduleCode}", $input);

		// Assert
		$this->assertEquals(
			$input['is_logo'],
			Module::find($moduleId)->originalLogo()
		);


		File::deleteDirectory(base_path("public/resources/{$moduleCode}"));
	}

	/**
	 * Here we will generate module dummy images
	 *
	 * @return void
	 */
	protected function createModuleImage($moduleCode, $howMuch = 1)
	{
		foreach (range(1, $howMuch) as $i)
		{
			if (!is_dir($dir = base_path("public/resources/{$moduleCode}")))
	        {
	            mkdir($dir, 0777, true);
	        }

			File::copy(
				app_path('tests/resources/images/dummy.png'), // our dummy image
				base_path("public/resources/{$moduleCode}/{$i}.png")
			);
		}
	}

	/**
	 * Here we will grab the first module code in database
	 *
	 * @return string
	 */
	protected function getFirstModule()
	{
		return Module::first();
	}

	/**
	 * Here we will simply generate dummy module info(data)
	 *
	 * @return array
	 */
	protected function getModuleDummyData()
	{
		return [
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
	}
	
}