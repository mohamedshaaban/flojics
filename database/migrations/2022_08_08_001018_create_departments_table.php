<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name_en', 191);
			$table->string('name_ar', 191);
			$table->string('slug', 191);
			$table->string('short_description_en', 191);
			$table->string('short_description_ar', 191);
			$table->text('description_en', 65535);
			$table->text('description_ar', 65535);
			$table->string('desc_image_en', 191)->nullable();
			$table->string('desc_image_ar', 191)->nullable();
			$table->string('desc_video_en', 191)->nullable();
			$table->string('desc_video_ar', 191)->nullable();
			$table->string('image', 191);
			$table->string('phone', 191);
			$table->integer('status')->default(1);
			$table->integer('in_home')->default(0);
			$table->text('meta_title_en', 65535)->nullable();
			$table->text('meta_title_ar', 65535)->nullable();
			$table->text('meta_keywords_en', 65535)->nullable();
			$table->text('meta_keywords_ar', 65535)->nullable();
			$table->text('meta_description_en', 65535)->nullable();
			$table->text('meta_description_ar', 65535)->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->text('his_ref', 65535)->nullable();
			$table->string('show_appt', 191)->nullable()->default('0');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('departments');
	}

}
