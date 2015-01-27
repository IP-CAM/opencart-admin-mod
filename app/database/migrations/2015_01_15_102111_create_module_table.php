<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modules', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code', 255)->unique();
			$table->text('version', '0.0.1');
			$table->integer('price')->default(0);
			$table->integer('downloads')->default(0);
			$table->integer('status')->default(0);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('modules');
	}

}
