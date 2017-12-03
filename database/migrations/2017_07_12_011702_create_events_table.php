<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	public function up()
	{
		Schema::create('events', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('name', 255);
			$table->string('description')->nullable();
			$table->text('article')->nullable();
			$table->integer('doctor_id')->unsigned()->nullable();
			$table->softDeletes();
			$table->integer('views')->default('0');
			$table->timestamp('starts_at')->nullable();
			$table->timestamp('ends_at')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('events');
	}
}