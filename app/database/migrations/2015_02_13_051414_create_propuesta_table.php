<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropuestaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('propuestas', function($table) {
			$table->integer('id')->primary();
			$table->string('nombre_propuesta');
			$table->string('nombre', 60);
			$table->string('escuela', 60);
			$table->string('area', 150);
			$table->string('email', 100);
			$table->tinyInteger('status');
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
		Schema::drop('propuestas');
	}

}
