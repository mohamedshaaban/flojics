<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('email', 191)->unique();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password', 191);
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->string('first_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('phone', 191)->nullable();
			$table->string('file', 191)->nullable();
			$table->string('dob', 191)->nullable();
			$table->string('age', 191)->nullable();
			$table->string('gender', 191)->nullable();
			$table->string('otp', 191)->nullable();
			$table->string('his_ref', 191)->nullable();
			$table->string('profile_picture', 191)->nullable();
			$table->string('passport', 191)->nullable();
			$table->string('civil_id', 191)->nullable();
			$table->string('passport_id', 191)->nullable();
			$table->string('update_phone', 191)->nullable();
			$table->string('update_email', 191)->nullable();
			$table->string('update_profile_picture', 191)->nullable();
			$table->string('update_otp', 191)->nullable();
			$table->string('reset_password_otp', 191)->nullable();
			$table->string('whatsapp_number', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
