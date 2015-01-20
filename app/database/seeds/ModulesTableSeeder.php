<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ModulesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
			$today = Carbon\Carbon::now();

			Blocks\Models\Module::create([
				'code' => $faker->word,
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