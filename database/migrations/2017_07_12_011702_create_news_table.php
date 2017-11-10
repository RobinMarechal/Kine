<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration {

	public function up()
	{
		Schema::create('news', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->softDeletes();
			$table->integer('doctor_id')->unsigned()->nullable();
			$table->string('title', 255);
			$table->text('content');
			$table->timestamp('published_at');
			$table->integer('views')->default('0');
		});
	}

	public function down()
	{
		Schema::drop('news');
	}
}