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
		Schema::create('users',function(Blueprint $table) {
			$table->increments('id');
            $table->text('namePrefix')->nullable();
            $table->text('firstName');
            $table->text('lastName');
            $table->text('nameSuffix')->nullable();
			$table->string('email')->unique();
			$table->string('password')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->rememberToken();
			$table->char('canLogIn',1)->default('N');
			$table->datetime('suspend_until')->nullable();
			$table->unsignedBigInteger('accountRequestId')->default(0);

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
