<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('prefix_en', 191);
			$table->string('prefix_ar', 191);
			$table->string('name_en', 191);
			$table->string('name_ar', 191);
			$table->string('slug', 191);
			$table->string('gender', 191);
			$table->string('picture', 191);
			$table->text('brief_en', 65535)->nullable();
			$table->text('brief_ar', 65535)->nullable();
			$table->string('working_date', 191)->nullable();
			$table->text('certificates_en', 65535)->nullable();
			$table->text('certificates_ar', 65535)->nullable();
			$table->text('experience_description_en', 65535)->nullable();
			$table->text('experience_description_ar', 65535)->nullable();
			$table->text('education_en', 65535);
			$table->text('education_ar', 65535);
			$table->text('achievments_en', 65535)->nullable();
			$table->text('achievments_ar', 65535)->nullable();
			$table->integer('department_id')->unsigned();
			$table->integer('specialty_id')->unsigned();
			$table->integer('nationality_id')->unsigned();
			$table->integer('status')->default(1);
			$table->text('meta_title_en', 65535)->nullable();
			$table->text('meta_title_ar', 65535)->nullable();
			$table->text('meta_keywords_en', 65535)->nullable();
			$table->text('meta_keywords_ar', 65535)->nullable();
			$table->text('meta_description_en', 65535)->nullable();
			$table->text('meta_description_ar', 65535)->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->integer('in_home')->default(0);
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
		Schema::drop('doctors');
	}

}
