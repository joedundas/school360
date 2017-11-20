<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('students');
		Schema::create('students', function(Blueprint $table)
		{
			$table->increments('id');
            $table->text('firstName');
            $table->text('lastName');
            $table->text('email');
            $table->char('currentGradeLevel');
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
		Schema::drop('students');
	}

}
