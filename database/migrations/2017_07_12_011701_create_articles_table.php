<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

	public function up()
	{
		Schema::create('articles', function(Blueprint $table) {
			$table->increments('id');
			$table->softDeletes();
			$table->integer('user_id')->unsigned()->nullable();
			$table->string('title', 255);
			$table->text('content');
			$table->string('picture', 255)->nullable();
			$table->integer('views')->default('0');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::drop('articles');
	}
}