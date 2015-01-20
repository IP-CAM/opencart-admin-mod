<?php


class TestCase extends Illuminate\Foundation\Testing\TestCase {


	protected $nestedViewsData = array();


	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication() {
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__ . '/../../bootstrap/start.php';
	}


	public function tearDown()
    {
        Mockery::close();
    }


    public function mock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }


  /**
   * Default preparation for each test
   *
   */
  public function setUp()
  {
    parent::setUp();
 
    $this->prepareForTests();
  }


	/**
	 * Migrates the database and set the mailer to 'pretend'.
	 * This will cause the tests to run quickly.
	 *
	 */
	private function prepareForTests() {
		// Artisan::call('migrate');
		// Artisan::call('db:seed');

		exec('rm ' . __DIR__ . '/../database/testing/testdb.sqlite');
		exec('cp ' . __DIR__ . '/../database/testing/stubdb.sqlite ' . __DIR__ .     '/../database/testing/testdb.sqlite');

		Mail::pretend(true);
	}


	public function registerNestedView($view) {
		View::composer($view, function ($view) {
			$this->nestedViewsData[$view->getName()] = $view->getData();
		});
	}


	/**
	 * Assert that the given view has a given piece of bound data.
	 *
	 * @param  string|array  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function assertNestedViewHas($view, $key, $value = null) {
		if (is_array($key)) {return $this->assertNestedViewHasAll($view, $key);
		}

		if (!isset($this->nestedViewsData[$view])) {
			return $this->assertTrue(false, 'The view was not called.');
		}

		$data = $this->nestedViewsData[$view];

		if (is_null($value)) {
			$this->assertArrayHasKey($key, $data);
		} else {
			if (isset($data[$key])) {
				$this->assertEquals($value, $data[$key]);
			} else {

				return $this->assertTrue(false, 'The View has no bound data with this key.');
			}
		}
	}


	/**
	 * Assert that the view has a given list of bound data.
	 *
	 * @param  array  $bindings
	 * @return void
	 */
	public function assertNestedViewHasAll($view, array $bindings) {
		foreach ($bindings as $key => $value) {
			if (is_int($key)) {
				$this->assertNestedViewHas($view, $value);
			} else {
				$this->assertNestedViewHas($view, $key, $value);
			}
		}
	}


	public function assertNestedView($view) {
		$this->assertArrayHasKey($view, $this->nestedViewsData);
	}


}
