<?php

class Archivo extends Eloquent {
	protected $table = 'archivos';

	public function Propuesta() {
		return $this->belongsTo('Propuesta', 'id_propuesta');
	}
}