<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureFlips extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feature_flips', function(Blueprint $table)
		{
			$table->unsignedBigInteger('schoolId')->default(0);
			$table->char('code',20);
			$table->char('subcode',20);
			$table->index(array('code','subcode'));
			$table->primary(array('code','subcode','schoolId'));
			$table->char('status',3)->default('off');
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
		Schema::drop('feature_flips');
	}

}
