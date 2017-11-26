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
			$table->unsignedBigInteger('userId');
			$table->unsignedBigInteger('schoolId');
			$table->char('asUserType',20);
			$table->unsignedBigInteger('asUserTypeId');
			$table->char('permissionCode','10');
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
