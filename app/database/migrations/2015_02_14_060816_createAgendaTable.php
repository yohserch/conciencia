<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agendas', function($table) {
			$table->increments('id');
			$table->dateTime('fecha');
			$table->time('hora_inicio');
			$table->time('hora_fin');
			$table->string('sede');
			$table->string('latitud');
			$table->string('longitud');
			$table->nullableTimestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agendas');
	}

}
