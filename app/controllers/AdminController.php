<?php 

use Carbon\Carbon;

class AdminController extends BaseController {

	public function getHome() {
		return View::make("admin.home");
	}

	public function getEventos() {
		$eventos = Agenda::all();
		return View::make('admin.eventos');
	}

	public function createEvent() {
		if (Session::token() == Input::get("_token")) {
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
					'msj' => 'Algunos campos contienen datos erroneos',
					'errors' => $validator->getMessageBag()->jsonSerialize()
				));
			} else {
				if(Input::get("id") != "") {
					$agenda = Agenda::find(Input::get('id'));
					$msj = 'Evento modificado con éxito';
				} else {
					$agenda = new Agenda();
					$msj = 'Evento creado con éxito';
				}
				$fecha = Carbon::createFromFormat("d-m-Y", Input::get('fecha'), 'America/Mexico_City');
				$agenda->fecha = $fecha->toDateTimeString();
				$agenda->hora_inicio = Input::get('hora_inicio').':00';
				$agenda->hora_fin = Input::get('hora_fin').':00';
				$agenda->sede = Input::get("sede");
				$agenda->lugar = Input::get('lugar');
				$agenda->latitud = Input::get('latitud');
				$agenda->longitud = Input::get('longitud');
				if($agenda->save()) {
					return Response::json(array(
						'msj' => $msj,
						'edited' => Input::get('id') != '',
						'event' => $agenda
					));
				}
			}
		}

		return Response::json(array(
			'msj' => 'Error al crear el evento, intente de nuevo o contacte a sistemas'
		));
	}

	public function removeEvent($id) {
		$evento = Agenda::find($id);
		if($evento->delete()) {
			return Response::json(array(
				'msj' => 'Evento eliminado con éxito',
				'status' => 'success'
			));
		} else {
			return Response::json(array(
				'msj' => 'Error al procesar la solicitud',
				'status' => 'error'
			));
		}
	}

	public function getEvento($id) {
		$evento = Agenda::find($id);
		return Response::json(array(
			'evento' => $evento
		));
	}

	public function getPropuestas() {
		$propuestas = Propuesta::all();
		return View::make('admin.propuestas')->with("propuestas", $propuestas);
	}

	public function getGalerias() {
		return View::make('admin.galerias');
	}

	public function postGalerias() {
		$validator = Validator::make(Input::all(),
			array(
				'nombre' => 'required|max:60'
			)
		);
		if($validator->fails()) {
			return Response::json(array(
				'msj' => 'Algunos campos contienen datos erroneos',
				'errors' => $validator->getMessageBag()->jsonSerialize()
			));
		}

		if(Input::get('id') != "") {
			$galeria = Galeria::find(Input::get('id'));
			$msj = "Galeria modificada con éxito";
		} else {
			$galeria = new Galeria;
		}

		$galeria->nombre = Input::get('nombre_galeria');
		$galeria->save();
		return Response::json(
			array(
				'msj' => $msj,
				'edited' => Input::get('id') != "",
				'galeria' => $galeria
			)
		);
	}
}