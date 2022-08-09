<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('main_reception_phone', 191);
			$table->text('testimonial_description_en', 65535);
			$table->text('testimonial_description_ar', 65535);
			$table->text('doctor_description_en', 65535);
			$table->text('doctor_description_ar', 65535);
			$table->text('department_description_en', 65535);
			$table->text('department_description_ar', 65535);
			$table->string('management_img_en', 191);
			$table->string('management_img_ar', 191)->nullable();
			$table->text('award_description_en', 65535);
			$table->text('award_description_ar', 65535);
			$table->text('management_message_en', 65535);
			$table->text('management_message_ar', 65535);
			$table->text('nav_message_en', 65535)->nullable();
			$table->text('nav_message_ar', 65535)->nullable();
			$table->string('nav_slug', 191)->nullable();
			$table->string('nav_image', 191)->nullable();
			$table->integer('popup_status')->default(0);
			$table->string('popup_title_en', 191);
			$table->string('popup_title_ar', 191);
			$table->text('popup_description_en', 65535);
			$table->text('popup_description_ar', 65535);
			$table->text('chat', 65535)->nullable();
			$table->integer('publication_item')->default(0);
			$table->integer('photos_videos_item')->default(0);
			$table->integer('news_item')->default(0);
			$table->integer('executive_management_item')->default(0);
			$table->integer('board_directors_item')->default(0);
			$table->text('application_email', 65535);
			$table->text('appointment_email', 65535);
			$table->text('contact_email', 65535);
			$table->text('google_analytic', 65535)->nullable();
			$table->string('tour_image', 191);
			$table->string('tour_title_en', 191);
			$table->string('tour_title_ar', 191);
			$table->text('tour_description_en', 65535);
			$table->text('tour_description_ar', 65535);
			$table->string('header_phone', 191);
			$table->string('address_en', 191);
			$table->string('address_ar', 191);
			$table->string('working_hours_en', 191);
			$table->string('working_hours_ar', 191);
			$table->string('email_info', 191);
			$table->string('facebook', 191);
			$table->string('instagram', 191);
			$table->string('twitter', 191);
			$table->string('linked_in', 191);
			$table->string('you_tube', 191);
			$table->text('google_map', 65535);
			$table->string('wara_image_en', 191);
			$table->string('wara_image_ar', 191);
			$table->string('wellness_en', 191);
			$table->string('wellness_ar', 191);
			$table->string('wellness_video_en', 191);
			$table->string('wellness_video_ar', 191);
			$table->text('wellness_description_en', 65535);
			$table->text('wellness_description_ar', 65535);
			$table->string('appreciation_en', 191);
			$table->string('appreciation_ar', 191);
			$table->string('appreciation_video_en', 191);
			$table->string('appreciation_video_ar', 191);
			$table->text('appreciation_description_en', 65535);
			$table->text('appreciation_description_ar', 65535);
			$table->string('respect_en', 191);
			$table->string('respect_ar', 191);
			$table->string('respect_video_en', 191);
			$table->string('respect_video_ar', 191);
			$table->text('respect_description_en', 65535);
			$table->text('respect_description_ar', 65535);
			$table->string('attentive_en', 191);
			$table->string('attentive_ar', 191);
			$table->string('attentive_video_en', 191);
			$table->string('attentive_video_ar', 191);
			$table->text('attentive_description_en', 65535);
			$table->text('attentive_description_ar', 65535);
			$table->text('way_wara_description_en', 65535);
			$table->text('way_wara_description_ar', 65535);
			$table->string('way_wara_desc_image_en', 191)->nullable();
			$table->string('way_wara_desc_image_ar', 191)->nullable();
			$table->string('way_wara_desc_video_en', 191)->nullable();
			$table->string('way_wara_desc_video_ar', 191)->nullable();
			$table->string('banner_management', 191);
			$table->string('title_management_en', 191);
			$table->string('title_management_ar', 191);
			$table->string('name_management_en', 191);
			$table->string('name_management_ar', 191);
			$table->text('body_management_en', 65535);
			$table->text('body_management_ar', 65535);
			$table->string('img_management', 191);
			$table->string('board_banner', 191);
			$table->string('executive_banner', 191);
			$table->string('executive_title_en', 191);
			$table->string('executive_title_ar', 191);
			$table->text('executive_description_en', 65535);
			$table->text('executive_description_ar', 65535);
			$table->string('board_title_en', 191);
			$table->string('board_title_ar', 191);
			$table->text('board_description_en', 65535);
			$table->text('board_description_ar', 65535);
			$table->string('banner_doctor', 191);
			$table->string('title_doctor_en', 191);
			$table->string('title_doctor_ar', 191);
			$table->text('body_doctor_en', 65535);
			$table->text('body_doctor_ar', 65535);
			$table->string('title_career_en', 191);
			$table->string('title_career_ar', 191);
			$table->text('description_career_en', 65535);
			$table->text('description_career_ar', 65535);
			$table->string('career_img', 191);
			$table->text('testimonials_meta_title_en', 65535)->nullable();
			$table->text('testimonials_meta_title_ar', 65535)->nullable();
			$table->text('testimonials_meta_keywords_en', 65535)->nullable();
			$table->text('testimonials_meta_keywords_ar', 65535)->nullable();
			$table->text('testimonials_meta_description_en', 65535)->nullable();
			$table->text('testimonials_meta_description_ar', 65535)->nullable();
			$table->text('careers_meta_title_en', 65535)->nullable();
			$table->text('careers_meta_title_ar', 65535)->nullable();
			$table->text('careers_meta_keywords_en', 65535)->nullable();
			$table->text('careers_meta_keywords_ar', 65535)->nullable();
			$table->text('careers_meta_description_en', 65535)->nullable();
			$table->text('careers_meta_description_ar', 65535)->nullable();
			$table->text('awards_meta_title_en', 65535)->nullable();
			$table->text('awards_meta_title_ar', 65535)->nullable();
			$table->text('awards_meta_keywords_en', 65535)->nullable();
			$table->text('awards_meta_keywords_ar', 65535)->nullable();
			$table->text('awards_meta_description_en', 65535)->nullable();
			$table->text('awards_meta_description_ar', 65535)->nullable();
			$table->text('departments_meta_title_en', 65535)->nullable();
			$table->text('departments_meta_title_ar', 65535)->nullable();
			$table->text('departments_meta_keywords_en', 65535)->nullable();
			$table->text('departments_meta_keywords_ar', 65535)->nullable();
			$table->text('departments_meta_description_en', 65535)->nullable();
			$table->text('departments_meta_description_ar', 65535)->nullable();
			$table->text('doctors_meta_title_en', 65535)->nullable();
			$table->text('doctors_meta_title_ar', 65535)->nullable();
			$table->text('doctors_meta_keywords_en', 65535)->nullable();
			$table->text('doctors_meta_keywords_ar', 65535)->nullable();
			$table->text('doctors_meta_description_en', 65535)->nullable();
			$table->text('doctors_meta_description_ar', 65535)->nullable();
			$table->text('board_meta_title_en', 65535)->nullable();
			$table->text('board_meta_title_ar', 65535)->nullable();
			$table->text('board_meta_keywords_en', 65535)->nullable();
			$table->text('board_meta_keywords_ar', 65535)->nullable();
			$table->text('board_meta_description_en', 65535)->nullable();
			$table->text('board_meta_description_ar', 65535)->nullable();
			$table->text('management_meta_title_en', 65535)->nullable();
			$table->text('management_meta_title_ar', 65535)->nullable();
			$table->text('management_meta_keywords_en', 65535)->nullable();
			$table->text('management_meta_keywords_ar', 65535)->nullable();
			$table->text('management_meta_description_en', 65535)->nullable();
			$table->text('management_meta_description_ar', 65535)->nullable();
			$table->text('wara_meta_title_en', 65535)->nullable();
			$table->text('wara_meta_title_ar', 65535)->nullable();
			$table->text('wara_meta_keywords_en', 65535)->nullable();
			$table->text('wara_meta_keywords_ar', 65535)->nullable();
			$table->text('wara_meta_description_en', 65535)->nullable();
			$table->text('wara_meta_description_ar', 65535)->nullable();
			$table->text('contact_meta_title_en', 65535)->nullable();
			$table->text('contact_meta_title_ar', 65535)->nullable();
			$table->text('contact_meta_keywords_en', 65535)->nullable();
			$table->text('contact_meta_keywords_ar', 65535)->nullable();
			$table->text('contact_meta_description_en', 65535)->nullable();
			$table->text('contact_meta_description_ar', 65535)->nullable();
			$table->text('home_meta_title_en', 65535)->nullable();
			$table->text('home_meta_title_ar', 65535)->nullable();
			$table->text('home_meta_keywords_en', 65535)->nullable();
			$table->text('home_meta_keywords_ar', 65535)->nullable();
			$table->text('home_meta_description_en', 65535)->nullable();
			$table->text('home_meta_description_ar', 65535)->nullable();
			$table->text('meta_title_en', 65535)->nullable();
			$table->text('meta_title_ar', 65535)->nullable();
			$table->text('meta_keywords_en', 65535)->nullable();
			$table->text('meta_keywords_ar', 65535)->nullable();
			$table->text('meta_description_en', 65535)->nullable();
			$table->text('meta_description_ar', 65535)->nullable();
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
		Schema::drop('settings');
	}

}
