<?php

use Blocks\Models\Language;
use Faker\Factory as Faker;

class LanguagesTableSeeder extends Seeder {

	public function run()
	{
		\DB::table('languages')->truncate();

		$faker = Faker::create();
		$languages = [
			'en' => 'English', 
			'ru' => 'Русский', 
			'ua' => 'Українська'
		];

		foreach($languages as $code => $title)
		{
			$lang = new Language;
			$lang->code = $code;
			$lang->title = $title;
			$lang->save();
		}
	}

}