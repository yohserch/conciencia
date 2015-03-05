<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('archivos', function($table) {
			$table->integer('id')->primary();
			$table->integer('id_propuesta');
			$table->string('nombre_statico', 70);
			$table->string('nombre_real', 80);
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
		Schema::drop('archivos');
	}

}
