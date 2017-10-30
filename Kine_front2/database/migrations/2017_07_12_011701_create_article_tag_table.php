<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleTagTable extends Migration {

	public function up()
	{
		Schema::create('article_tag', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('tag_id')->unsigned();
			$table->integer('article_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('article_tag');
	}
}