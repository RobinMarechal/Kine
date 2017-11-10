<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function(Blueprint $table)
		{
//			$table->increments('id');
			$table->integer('id')->unsigned()->unique()->nullable(false);
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('name')->nullable();
//			$table->integer('user_id')->nullable()->unsigned();
			$table->string('phone', 12)->nullable();
			$table->time('starts_at')->nullable();
			$table->time('ends_at')->nullable();
			$table->string('resume')->nullable();
			$table->text('description')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctors');
    }
}
