<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagUserTable extends Migration {

	public function up()
	{
		Schema::create('tag_user', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('user_id')->unsigned();
			$table->integer('tag_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('tag_user');
	}
}