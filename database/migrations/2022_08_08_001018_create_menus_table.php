<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name_en', 191);
			$table->string('name_ar', 191);
			$table->string('url', 191);
			$table->string('word_activ', 191);
			$table->integer('in_why_wara')->default(0);
			$table->integer('in_footer')->default(0);
			$table->integer('in_header')->default(0);
			$table->integer('order')->default(0);
			$table->integer('status')->default(0);
			$table->softDeletes();
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
		Schema::drop('menus');
	}

}
