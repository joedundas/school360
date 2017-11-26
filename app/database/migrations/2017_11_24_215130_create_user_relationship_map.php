<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRelationshipMap extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_relationship_map', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedBigInteger('userRoleId');
			$table->unsignedBigInteger('relatedTo_userRoleId');
			$table->char('relatedToIs');
			$table->date('startDate')->nullable();
			$table->date('endDate')->nullable();
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
		Schema::drop('user_relationship_map');
	}

}
