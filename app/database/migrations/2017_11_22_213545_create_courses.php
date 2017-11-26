<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('courseName');
			$table->text('courseDescription');
			$table->unsignedInteger('gradeLevelBegin')->nullable();
			$table->unsignedInteger('gradeLevelEnd')->nullable();
			$table->unsignedInteger('ageRequirement')->nullable();
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
		Schema::drop('courses');
	}

}
