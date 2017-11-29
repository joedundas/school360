<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationRoleDefaults extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('authorization_role_defaults', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('role',20);
			$table->char('permissionCode',20);
			$table->text('defaultValue')->nullable();
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
		Schema::drop('authorization_role_defaults');
	}

}
