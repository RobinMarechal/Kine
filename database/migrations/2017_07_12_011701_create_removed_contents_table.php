<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRemovedContentsTable extends Migration {

	public function up()
	{
		Schema::create('removed_contents', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
			$table->string('name', 255);
			$table->text('content')->nullable();
			$table->integer('doctor_id')->unsigned()->nullable();
			$table->timestamp('removed_at')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}

	public function down()
	{
		Schema::drop('removed_contents');
	}
}