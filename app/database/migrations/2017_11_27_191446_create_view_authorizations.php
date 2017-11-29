<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewAuthorizations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('authorization_views', function(Blueprint $table)
		{
			$table->char('item',50)->unique();
			$table->text('authorizationsRequired')->nullable();
			$table->text('rolesRequired')->nullable();
			$table->text('rolesRestricted')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('authorization_views');
	}

}
