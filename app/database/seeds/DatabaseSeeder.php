<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// Turn off foreign keys
		if (App::Environment() !== 'testing')
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

		$this->call('UsersTableSeeder');
		$this->call('LanguagesTableSeeder');
		$this->call('ModulesTableSeeder');
		$this->call('ModuleLanguageTableSeeder');

		// Turn on foreign keys
		if (App::Environment() !== 'testing')
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
	}

}
