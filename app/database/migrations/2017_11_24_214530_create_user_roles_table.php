<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('role',15);
			$table->unsignedBigInteger('userId');
			$table->unsignedBigInteger('schoolId');
			$table->date('beginDate')->nullable();
			$table->date('endDate')->nullable();
			$table->char('canLogin',1)->default('Y');
			$table->char('default_role',1)->default('Y');

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_roles');
	}

}
