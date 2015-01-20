<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		DB::table('users')->truncate();

		// 0122333 -> $2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy
		User::create([
			'login' => 'admin',
			'password' => '$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',
			'email' => 'admin@gmail.com',
			'is_admin' => '1',
		]);

		foreach(range(1, 10) as $index)
		{
			User::create([
				'login' => $faker->username,
				'password' => '$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',
				'email' => $faker->email,
				'is_admin' => '0',
			]);
		}
	}

}