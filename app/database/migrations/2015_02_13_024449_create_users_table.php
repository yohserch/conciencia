<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table) {
			$table->engine = 'MyIsam';
			$table->integer('id')->primary();
			$table->string('username', 30)->unique();
			$table->string('nombre', 30);
			$table->string('apellidoP', 30);
			$table->string('apellidoM',30);
			$table->string('email', 60)->unique();
			$table->string('password', 60);
			$table->string('password_temp', 60);
			$table->string('codigo', 60);
			$table->boolean('activo');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
