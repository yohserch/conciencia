<?php 

class Galeria extends Eloquent {
	protected $table = 'Galerias';

	public function imagenes() {
		return $this->hasMany('Imagen', 'id_galeria');
	}
}