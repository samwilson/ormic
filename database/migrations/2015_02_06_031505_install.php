<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Install extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->users();
        $this->changes();
    }

    private function users()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->rememberToken();
        });
        Schema::create('user_passwords', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('password');
        });
        Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });
        Schema::create('role_user', function(Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->primary(['user_id', 'role_id']);
        });
    }

    private function changes()
    {
//        Schema::create('changesets', function(Blueprint $table) {
//            $table->increments('id');
//            $table->datetime('date_and_time');
//            $table->text('comment');
//            $table->integer('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users');
//        });
//        Schema::create('changes', function(Blueprint $table) {
//            $table->increments('id');
//            $table->integer('changeset_id')->unsigned();
//            $table->foreign('changeset_id')->references('id')->on('changesets');
//            $table->string('model');
//            $table->integer('model_pk');
//            $table->enum('change_type', array('field', 'file', 'foreign'));
//            $table->string('field');
//            $table->text('old_value');
//            $table->text('new_value');
//        });
        Schema::create('datalog', function(Blueprint $table) {
            $table->increments('id');
            $table->string('date_and_time');
            $table->string('table');
            $table->string('field');
            $table->integer('row');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
}
