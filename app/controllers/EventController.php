<?php

use Carbon\Carbon;

class EventController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $eventos = Agenda::all();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), array(
			'fecha' => 'required|date|date_format:d-m-Y',
			'sede' => 'required',
			'lugar' => 'required',
			'hora_inicio' => 'required|date_format:H:m',
			'hora_fin' => 'required|date_format:H:m',
			'latitud' => 'required',
			'longitud' => 'required'
		));
		if($validator->fails()) {
			return Response::json(array(
				'error' => true,
				'msj' => "Error al guardar, por favor verifique los datos"
			));
		}

		$evento = new Agenda;
		$fecha = Carbon::createFromFormat("d-m-Y", Input::get('fecha'), 'America/Mexico_City');
		$evento->fecha = $fecha;
		$evento->hora_inicio = Input::get('hora_inicio').':00';
		$evento->hora_fin = Input::get('hora_fin').':00';
		$evento->sede = Input::get('sede');
		$evento->lugar = Input::get('lugar');
		$evento->latitud = Input::get('latitud');
		$evento->longitud = Input::get('longitud');
		$evento->save();
		return Response::json(array(
			'error' => false,
			'msj' => "Evento guardado con éxito",
			'object' => $evento
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
		return Agenda::find($id);
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
			'fecha' => 'required|date|date_format:d-m-Y',
			'sede' => 'required',
			'lugar' => 'required',
			'hora_inicio' => 'required|date_format:H:m',
			'hora_fin' => 'required|date_format:H:m',
			'latitud' => 'required',
			'longitud' => 'required'
		));
		if($validator->fails()) {
			return Response::json(array(
				'error' => true,
				'msj' => "Error al actualizar, por favor verifique los datos"
			));
		}

		$evento = Agenda::find($id);
		$fecha = Carbon::createFromFormat("d-m-Y", Input::get('fecha'), 'America/Mexico_City');
		$evento->fecha = $fecha;
		$evento->hora_inicio = Input::get('hora_inicio').':00';
		$evento->hora_fin = Input::get('hora_fin').':00';
		$evento->sede = Input::get('sede');
		$evento->lugar = Input::get('lugar');
		$evento->latitud = Input::get('latitud');
		$evento->longitud = Input::get('longitud');
		$evento->save();
		return Response::json(array(
			'error' => false,
			'msj' => "Actualización realizada con éxito",
			'object' => $evento
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
		$evento = Agenda::find($id);
		$evento->delete();
		return Response::json(array(
			'msj' => 'Evento eliminado con éxito',
			'id' => $id
		));
	}

	/**
	 * Show the view of the events
	 * @return View
	 */
	public function showView() 
	{
		return View::make('admin.eventos');
	}

}
