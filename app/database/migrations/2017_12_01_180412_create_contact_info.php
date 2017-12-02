<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_info', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedBigInteger('userId');
			$table->unsignedBigInteger('userRoleId');
			$table->char('isDefault',1)->default('N');
			$table->char('contactType',15);
			$table->char('entryType',15);
			$table->text('contactInfo');
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
		Schema::drop('contact_info');
	}

}
