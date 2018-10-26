<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiCalls extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('api_calls', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('roleId');
            $table->unsignedBigInteger('schoolId');
			$table->longText('information');
			$table->text('routeClass');
			$table->text('routeMethod');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('api_calls');
	}

}
