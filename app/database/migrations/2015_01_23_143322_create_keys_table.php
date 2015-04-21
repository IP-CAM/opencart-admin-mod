<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKeysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('keys', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('module_code', 255);
			$table->foreign('module_code')->references('code')->on('modules')->onDelete('restrict');
			$table->string('domain');
			$table->date('expired_at')->nullable()->default(NULL);
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
		Schema::drop('keys');
	}

}
