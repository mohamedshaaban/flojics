<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppointmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appointments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('phone_number', 191);
			$table->string('email', 191)->nullable();
			$table->string('civil_id', 191)->nullable();
			$table->string('preffered_date', 191)->nullable();
			$table->text('message', 65535)->nullable();
			$table->integer('status')->default(0);
			$table->integer('doctor_id')->unsigned();
			$table->integer('department_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();
			$table->string('his_ref', 191)->nullable();
			$table->string('appointment_time', 191)->nullable();
			$table->string('end_time', 191)->nullable();
			$table->string('passport_no', 191)->nullable();
			$table->string('dob', 191)->nullable();
			$table->string('age', 191)->nullable();
			$table->string('gender', 191)->nullable();
			$table->string('charge_price', 191)->nullable();
			$table->string('payment_status_id', 191)->nullable();
			$table->string('reference_number', 191)->nullable();
			$table->string('payment_type', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('reserved_time', 191)->nullable();
			$table->string('user_id', 191)->nullable();
			$table->text('remarks')->nullable();
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
		Schema::drop('appointments');
	}

}
