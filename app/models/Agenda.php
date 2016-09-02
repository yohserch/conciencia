<?php

use Carbon\Carbon;

class Agenda extends Eloquent {
	protected $table = 'agendas';

	public function getFechaAttribute($value) {
		return Carbon::createFromFormat('Y-m-d H:i:s', $value, 'America/Mexico_City')->format('d-m-Y');
	}

	public function getHoraInicioAttribute($value) {
		return Carbon::createFromFormat("H:i:s", $value, 'America/Mexico_City')->format('H:i');
	}

	public function getHoraFinAttribute($value) {
		return Carbon::createFromFormat("H:i:s", $value, 'America/Mexico_City')->format('H:i');
	}
}
