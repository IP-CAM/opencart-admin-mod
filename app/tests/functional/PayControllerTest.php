<?php 

class PayControllerTest extends TestCase
{

	protected $keyRepository;
	protected $moduleRepository;

	public function setUp()
	{
		parent::setUp();

		$this->keyRepository = App::make('Blocks\Repositories\KeyRepository');
		$this->moduleRepository = App::make('Blocks\Repositories\ModuleRepository');
	}
	
	/**
	 * @test
	 */
	public function it_should_open_page_with_payment_form()
	{
		$this->call('get', 'pay', [
			'domain' => 'example.com',
			'module' => 'test-download-module'
		]);

		$this->assertResponseStatus(200);
	}

	/**
	 * @test
	 */
	public function it_should_redirect_to_interkassa_on_submit()
	{
		// $this->assertRedirectedTo('')
	}

	/**
	 * @test
	 */
	public function it_vaildates_if_payment_was_good_and_create_new_module_to_domain_relation()
	{
		// $module = 'test-download-module';
		// $domain = 'opencart-new.dev';

		// $moduleInfo = $this->moduleRepository->find($module);

		// $response = [
		// 	"ik_co_id" => "54d38c70bf4efcad3252c4df",
		// 	"ik_inv_id" => "33606105",
		// 	"ik_inv_st" => "success",
		// 	"ik_inv_crt" => "2015-02-05 17:34:12",
		// 	"ik_inv_prc" => "2015-02-05 17:34:12",
		// 	"ik_pm_no" => "{$module}:{$domain}",
		// 	"ik_pw_via" => "test_interkassa_test_xts",
		// 	"ik_am" => "{$moduleInfo->price}",
		// 	"ik_co_rfn" => "11974.6500",
		// 	"ik_ps_price" => "12345.00",
		// 	"ik_cur" => "USD",
		// 	"ik_desc" => $moduleInfo->information->first()->title,
		// ];
		
		// $this->call('post', 'pay', $response);
		// $key = $this->keyRepository->byModuleAndDomain($module, $domain);

		// $this->assertNotNull($key);
		// $this->assertResponseStatus(200);
	}
	
}