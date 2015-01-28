<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ModulesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		$today = Carbon\Carbon::now();

		DB::table('modules')->truncate();

		Blocks\Models\Module::create([
			'code' => "test-download-module",
			'version' => '0.0.1',
			'price' => $faker->numberBetween(10, 100),
			'downloads' => $faker->numberBetween(1, 50),
			'status' => '1',
			'created_at' => $today,
			'updated_at' => $today,
		]);

		foreach(range(1, 10) as $index)
		{
			Blocks\Models\Module::create([
				'code' => $faker->unique->word,
				'version' => '0.0.1',
				'price' => $faker->numberBetween(10, 100),
				'downloads' => $faker->numberBetween(1, 50),
				'status' => '1',
				'created_at' => $today,
				'updated_at' => $today,
			]);
		}
	}

}