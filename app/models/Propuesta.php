<?php

class Propuesta extends Eloquent {
	protected $table = 'propuestas';

	public function archivos() {
		return $this->hasMany('Archivo', 'id_propuesta');
	}
}