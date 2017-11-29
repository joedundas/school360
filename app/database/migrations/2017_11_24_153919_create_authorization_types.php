<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('authorization_types', function(Blueprint $table)
		{
		    $table->char('permissionCategory',20);
		    $table->char('permissionSubCategory',20)->nullable();
		    $table->unsignedInteger('entryOrder');
		    $table->text('requires')->nullable();
		    $table->text('defaultValue')->nullable();
		    //$table->text('requiredBy')->nullable();
            $table->char('title',40);
			$table->char('permissionCode',20)->unique();
            $table->text('description');
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
		Schema::drop('authorization_types');
	}

}
