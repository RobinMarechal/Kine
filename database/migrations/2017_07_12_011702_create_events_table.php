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
			$table->text('description')->nullable();
			$table->integer('article_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->softDeletes();
			$table->integer('views')->default('0');
			$table->timestamp('startsAt')->nullable();
			$table->timestamp('endsAt')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('events');
	}
}