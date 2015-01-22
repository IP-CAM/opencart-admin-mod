<?php

use Blocks\Models\Module;
use Blocks\Models\ModuleLanguage;
use Faker\Factory as Faker;

class ModuleLanguageTableSeeder extends Seeder {

	public function run()
	{
		\DB::table('module_languages')->truncate();

		$faker = Faker::create();
		$modules = Module::all()->toArray();
		$today = \Carbon\Carbon::now();
		$languages = ['en', 'ru', 'ua'];

		foreach($modules as $module)
		{
			foreach ($languages as $code)
			{
				$lang = new ModuleLanguage;
				$lang->module_id = $module['id'];
				$lang->language_code = $code;
				$lang->title = $faker->name;
				$lang->description = $faker->sentence(15);
				$lang->created_at = $today;
				$lang->updated_at = $today;
				$lang->save();
			}
		}
	}

}