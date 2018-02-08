<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->softDeletes();
			$table->string('email', 60)->unique();
			$table->string('name', 60);
			$table->string('facebook_id', 255)->nullable();
			$table->string('password', 60)->nullable();
			$table->string('remember_token', 255)->nullable();
			$table->integer('connections')->default(1)->unsigned();
			$table->boolean('is_doctor')->unsigned()->nullable(false)->default(false);
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}