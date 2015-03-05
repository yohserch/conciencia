<?php 

use Carbon\Carbon;

class AdminController extends BaseController {

	public function getHome() {
		return View::make("admin.home");
	}

	public function getNuevaFecha() {
		return View::make('admin.nuevaFecha');
	}

	public function postNuevaFecha() {
		$validator = Validator::make(Input::all(), array(
			'fecha' => 'required|after:now|date|date_format:Y-m-d',
			'lugar' => 'required',
			'hora_inicio' => 'required|date_format:H:m',
			'hora_fin' => 'required|date_format:H:m'
		));
		if($validator->fails()) {
			return Redirect::route('nuevaFecha')->withErrors($validator)->withInput(Input::all());
		} else {
			$agenda = new Agenda;
			$fecha = Carbon::createFromFormat("Y-m-d", Input::get('fecha'), 'America/Mexico_City');
			$agenda->fecha = $fecha->toDateTimeString();
			$hora_inicio = Carbon::createFromFormat("Y-m-d H:m", Input::get('fecha').' '.Input::get('hora_inicio'), 'America/Mexico_City');
			$agenda->hora_inicio = $hora_inicio->toDateTimeString();
			$hora_fin = Carbon::createFromFormat("Y-m-d H:m", Input::get('fecha').' '.Input::get('hora_fin'), 'America/Mexico_City');
			$agenda->hora_fin = $hora_fin->toDateTimeString();
			$agenda->lugar = Input::get('lugar');
			if($agenda->save()) {
				return Redirect::route('nuevaFecha')->with('message', 'Evento guardado con éxito');
			} else {
				return Redirect::route('nuevaFecha')->with('message', 'Error al guardar el nuevo evento, por favor intente más tarde');
			}
		}
	}
}