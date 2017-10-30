<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediasTable extends Migration {

	public function up()
	{
		Schema::create('medias', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->softDeletes();
			$table->enum('type', array('PICTURE', 'VIDEO', 'DOCUMENT'));
			$table->string('path', 255)->unique();
			$table->string('mediaable_type', 255)->nullable();
			$table->integer('mediaable_id')->nullable();
			$table->text('description')->nullable();
			$table->string('title', 255);
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('views')->default('0');
		});
	}

	public function down()
	{
		Schema::drop('medias');
	}
}