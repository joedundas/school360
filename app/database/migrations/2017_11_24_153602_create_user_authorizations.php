<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAuthorizations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_authorizations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedBigInteger('roleId');
			$table->unsignedBigInteger('schoolId');
			$table->char('permissionCode','20');
			$table->text('permissionValue');
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
		Schema::drop('user_authorizations');
	}

}
