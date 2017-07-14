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
			$table->string('email', 255)->unique();
			$table->string('name', 255);
			$table->string('facebook_id', 255)->nullable();
			$table->string('password', 255)->nullable();
			$table->integer('level')->default('0');
			$table->string('phone')->nullable();
			$table->time('starts_at')->nullable();
			$table->time('ends_at')->nullable();
			$table->boolean('is_doctor')->default(0);
			$table->string('remember_token', 255)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}