<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Install extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('username')->unique();
			$table->string('email');
			$table->string('password', 60);
			$table->rememberToken();
			$table->timestamps();
		});
		Schema::create('password_resets', function(Blueprint $table) {
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at');
		});
		Schema::create('asset_types', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title')->unique();
			$table->boolean('is_default')->default(false);
		});
		Schema::create('assets', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title')->unique();
			$table->integer('asset_type_id')->unsigned();
			$table->foreign('asset_type_id')->references('id')->on('asset_types');
		});
		Schema::create('job_types', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title')->unique();
			$table->integer('parent_job_type_id')->unsigned()->nullable();
			$table->foreign('parent_job_type_id')->references('id')->on('job_types');
		});
		Schema::create('jobs', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('asset_id')->unsigned();
			$table->foreign('asset_id')->references('id')->on('assets');
			$table->integer('job_type_id')->unsigned();
			$table->foreign('job_type_id')->references('id')->on('job_types');
		});
		Schema::create('tasks', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('job_id')->unsigned();
			$table->foreign('job_id')->references('id')->on('jobs');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users');
		Schema::dropIfExists('password_resets');
		Schema::dropIfExists('jobs');
		Schema::dropIfExists('assets');
		Schema::dropIfExists('asset_types');
	}

}
