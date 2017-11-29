<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureCodes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feature_codes', function(Blueprint $table)
		{
			$table->char('code',20);
			$table->char('subcode',20);
			$table->primary(array('code','subcode'));
			$table->char('defaultStatus',3)->default('off');
			$table->text('title');
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
		Schema::drop('feature_codes');
	}

}
