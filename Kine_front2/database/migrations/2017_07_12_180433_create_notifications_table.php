<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('user_id')->unsigned();
			$table->integer('notifiable_id')->nullable();
			$table->string('notifiable_type')->nullable();
			$table->timestamp('seen_at')->nullable();
			$table->string('content', 255);
			$table->string('link', 255)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}