<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserToSchoolMapper extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_school_mapper', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedBigInteger('userId');
			$table->unsignedBigInteger('roleId');
			$table->unsignedBigInteger('schoolId');
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
		Schema::drop('user_school_mapper');
	}

}
