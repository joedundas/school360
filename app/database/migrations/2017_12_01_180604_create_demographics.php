<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemographics extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('demographics', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedBigInteger('userId')->index();
			$table->unsignedBigInteger('userRoleId')->index();

			// actual demographics items should start with dem-, to make
            //  sure they are properly identified as demographical items
            //  when they are imported in to the DTO
			$table->date('dem-birthdate')->nullable();
			$table->text('dem-about');
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
		Schema::drop('demographics');
	}

}
