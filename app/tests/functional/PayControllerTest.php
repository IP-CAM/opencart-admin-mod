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
		// Arrange
		$response = $this->getSuccessPaymentResponse();
		$moduleCode = $response['ik_x_module_code'];
		$domain = $response['ik_x_domain'];

		$this->updateModulePrice($moduleCode, 100);
		$this->clearKeys();
		
		// Act
		$this->call('post', 'pay', $response);

		// Assert
		$this->checkIfKeyExists($moduleCode, $domain);
		$this->assertResponseOk();
	}

	/**
	 * Will return success response for payment (Interkassa).
	 * 
	 * Module code: test-download-module
	 * Price: 100$
	 *
	 * @return array
	 */
	protected function getSuccessPaymentResponse()
	{
		return [
				"ik_co_id" => "5370b5c3bf4efcad22ad7007",
	"ik_co_prs_id" => "202319528046",
	"ik_inv_id" => "36069295",
	"ik_inv_st" => "success",
	"ik_inv_crt" => "2015-04-29 12:14:00",
	"ik_inv_prc" => "2015-04-29 12:14:00",
	"ik_trn_id" => "",
	"ik_pm_no" => "ID_4233",
	"ik_pw_via" => "test_interkassa_test_xts",
	"ik_am" => "100.00",
	"ik_co_rfn" => "97.0000",
	"ik_ps_price" => "100.00",
	"ik_cur" => "USD",
	"ik_desc" => "Event Description",
	"ik_x_module_code" => "test-download-module",
	"ik_x_domain" => "modules.dev",
	"ik_sign" => "RB1rLcUHphnB2dTl2dJcig=="
		];
	}

	protected function updateModulePrice($moduleCode, $price = 0)
	{
		$this->moduleRepository->find($moduleCode)->update([
			'price' => $price
		]);
	}

	protected function clearKeys()
	{
		DB::table('keys')->truncate();
	}

	protected function checkIfKeyExists($moduleCode, $domain)
	{
		$key = $this->keyRepository->byModuleAndDomain($moduleCode, $domain);

		$this->assertNotNull($key);
		$this->assertEquals($key->module_code, $moduleCode);
		$this->assertEquals($key->domain, $domain);
	}

	
}