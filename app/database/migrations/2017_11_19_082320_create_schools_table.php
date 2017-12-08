<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::dropIfExists('schools');
        Schema::create('schools',function(Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('address');
            $table->text('address2')->nullable();
            $table->text('city');
            $table->char('state',2);
            $table->char('zip',9);
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
		//
        Schema::drop('schools');
	}

}
