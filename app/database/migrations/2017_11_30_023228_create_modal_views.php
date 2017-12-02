<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModalViews extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modal_views', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('title');
            $table->string('key');
            $table->char('width',3);
            $table->string('view');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('modal_views');
    }

}
