<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::dropIfExists('users');
		Schema::create('users',function($table) {
			$table->increments('id');
			$table->unsignedBigInteger('teacherId')->default(0);
            $table->unsignedBigInteger('staffId')->default(0);
            $table->unsignedBigInteger('parentId')->default(0);
            $table->unsignedBigInteger('studentId')->default(0);
			$table->string('email')->unique();
			$table->string('password');
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
		//
		Schema::drop('users');
	}

}
