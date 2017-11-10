<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseDoctorTable extends Migration {

	public function up()
	{
		Schema::create('course_doctor', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('course_id')->unsigned();
			$table->integer('doctor_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('course_doctor');
	}
}