<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
			$table->enum('type', array('PHONE', 'EMAIL', 'ADDRES', 'LINK'));
			$table->string('value', 255)->unique();
			$table->string('description', 255)->nullable();
			$table->integer('user_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}