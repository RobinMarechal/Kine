<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->enum('type', array('PHONE', 'EMAIL', 'ADDRESS', 'LINK'));
			$table->string('value', 255)->unique();
			$table->string('description', 255)->nullable();
			$table->integer('doctor_id')->unsigned()->nullable();
			$table->string('name', 60)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}