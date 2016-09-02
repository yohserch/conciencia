<?php 

class Imagen extends Eloquent {
	protected $table = 'Imagenes';
	protected $fillable = ['public_id'];

	public function galeria() {
		return $this->belongTo('Galeria', 'id_galeria');
	}
}