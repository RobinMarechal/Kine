<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('contents', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onUpdate('cascade');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onUpdate('cascade');
		});
		Schema::table('article_tag', function(Blueprint $table) {
			$table->foreign('tag_id')->references('id')->on('tags')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('article_tag', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('tag_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('tag_user', function(Blueprint $table) {
			$table->foreign('tag_id')->references('id')->on('tags')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('removed_contents', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onUpdate('cascade');
		});
		Schema::table('contacts', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onUpdate('cascade');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('set null')
						->onUpdate('cascade');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onUpdate('cascade');
		});
		Schema::table('medias', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onUpdate('cascade');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onUpdate('cascade');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('set null')
						->onUpdate('cascade');
		});
		Schema::table('course_doctor', function(Blueprint $table) {
			$table->foreign('course_id')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_doctor', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_user', function(Blueprint $table) {
			$table->foreign('course_id')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_tag', function(Blueprint $table) {
			$table->foreign('course_id')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_tag', function(Blueprint $table) {
			$table->foreign('tag_id')->references('id')->on('tags')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('user_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('cascade')
				  ->onUpdate('cascade');
		});
		Schema::table('skills', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('set null')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('contents', function(Blueprint $table) {
			$table->dropForeign('contents_user_id_foreign');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->dropForeign('articles_user_id_foreign');
		});
		Schema::table('article_tag', function(Blueprint $table) {
			$table->dropForeign('article_tag_tag_id_foreign');
		});
		Schema::table('article_tag', function(Blueprint $table) {
			$table->dropForeign('article_tag_article_id_foreign');
		});
		Schema::table('tag_user', function(Blueprint $table) {
			$table->dropForeign('tag_user_user_id_foreign');
		});
		Schema::table('tag_user', function(Blueprint $table) {
			$table->dropForeign('tag_user_tag_id_foreign');
		});
		Schema::table('removed_contents', function(Blueprint $table) {
			$table->dropForeign('removed_contents_user_id_foreign');
		});
		Schema::table('contacts', function(Blueprint $table) {
			$table->dropForeign('contacts_user_id_foreign');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->dropForeign('events_article_id_foreign');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->dropForeign('events_user_id_foreign');
		});
		Schema::table('medias', function(Blueprint $table) {
			$table->dropForeign('medias_user_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_user_id_foreign');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->dropForeign('courses_article_id_foreign');
		});
		Schema::table('course_doctor', function(Blueprint $table) {
			$table->dropForeign('course_doctor_course_id_foreign');
		});
		Schema::table('course_doctor', function(Blueprint $table) {
			$table->dropForeign('course_doctor_user_id_foreign');
		});
		Schema::table('course_user', function(Blueprint $table) {
			$table->dropForeign('course_user_course_id_foreign');
		});
		Schema::table('course_user', function(Blueprint $table) {
			$table->dropForeign('course_user_user_id_foreign');
		});
		Schema::table('course_tag', function(Blueprint $table) {
			$table->dropForeign('course_tag_course_id_foreign');
		});
		Schema::table('course_tag', function(Blueprint $table) {
			$table->dropForeign('course_tag_tag_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_user_id_foreign');
		});
		Schema::table('skills', function(Blueprint $table) {
			$table->dropForeign('skills_user_id_foreign');
		});
	}
}