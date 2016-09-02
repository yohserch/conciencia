<?php

class GalleryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Galeria::with('imagenes')->get();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), array(
			'nombre_galeria' => 'required'
		));

		if($validator->fails()) {
			return Response::json(array(
				'error' => true,
				'msj' => "Error al guardar, por favor verifique los datos"
			));
		}

		$galeria = new Galeria;
		$galeria->nombre = Input::get('nombre_galeria');
		$galeria->save();
		return Response::json(array(
			'error' => false,
			'msj' => "Galeria guardada con éxito",
			'object' => $galeria
		));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return View::make('admin.galeria')->with('galeria', Galeria::find($id));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validator = Validator::make(Input::all(), array(
			'nombre_galeria' => 'required'
		));

		if($validator->fails()) {
			return Response::json(array(
				'error' => true,
				'msj' => "Error al actualizar, por favor verifique los datos"
			));
		}

		$galeria = Galeria::find($id);
		$galeria->nombre = Input::get('nombre_galeria');
		$galeria->save();
		return Response::json(array(
			'error' => false,
			'msj' => "Actualización realziada con éxito",
			'object' => $galeria
		));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$galeria = Galeria::find($id);
		$galeria->delete();
		return Response::json(array(
			'msj' => 'Galeria eliminada con éxito',
			'id' => $id
		));
	}

	public function showView() {
		return View::make('admin.galerias');
	}

	public function addImages() {
		$galeria = Galeria::find(Input::get('galleryId'));
		$files = Input::file('file');
		$ids = [];
		$imagenes = [];
		foreach($files as $file) {
			$public_id = str_random(15);
			$fileUpload = Cloudy::upload($file, $public_id);
			$ids[] = array(
				'public_id' => $fileUpload->getResult()['public_id'],
				'url' => Cloudy::show($fileUpload->getResult()['public_id'], array('width' => 150, 'height' => 150, 'crop' => 'fit'))
			);
			$imagenes[] = new Imagen(array('public_id' => $fileUpload->getResult()["public_id"]));
		}
		$galeria->imagenes()->saveMany($imagenes);
		return Response::json($ids);
	}

	public function removeImage() {

	}
}
