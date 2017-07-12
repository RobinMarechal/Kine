<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration {

	public function up()
	{
		Schema::create('courses', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
			$table->integer('article_id')->unsigned()->nullable();
			$table->text('description')->nullable();
			$table->integer('views')->default('0');
		});
	}

	public function down()
	{
		Schema::drop('courses');
	}
}