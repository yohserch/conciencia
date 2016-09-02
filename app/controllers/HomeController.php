<?php

class HomeController extends BaseController {

	public function showWelcome() {
		return View::make('home.bienvenido');
	}

	public function showAgenda() {
		$eventos = Agenda::orderBy('fecha', 'ASC')->get();
		return View::make('home.agenda')->with('eventos', $eventos);
	}

	public function showGaleria() {
		$galerias = Galeria::all();
		return View::make('home.galeria')->with('galerias', $galerias);
	}

	public function showContactForm() {
		return View::make('home.contacto');
	}

	public function showFormPropuestas() {
		return View::make('home.propuestas');
	}

	public function savePropuesta() {
		$allows = ['pdf', 'docx', 'doc', 'xlsx', 'xls', 'png', 'jpg', 'jpeg', 'bmp'];
		$validator = Validator::make(Input::only('nombre', 'escuela', 'email', 'propuesta', 'area'), array(
						'nombre' => 'required|max:60',
						'area' => 'required',
						'propuesta' => 'required|max:100',
						'email' => 'required|email|max:100'
					));
		$failed = [];
		if($validator->fails()) {
			return Redirect::route('propuestas')
							 ->withErrors($validator)
							 ->withInput();
		} else {
			$files = [];
			$propuesta = new Propuesta;
			$propuesta->nombre = Input::get('nombre');
			$propuesta->nombre_propuesta = Input::get('propuesta');
			$propuesta->escuela = Input::get('escuela');
			$propuesta->area = Input::get('area');
			$propuesta->email = Input::get('email');
			$propuesta->save();
			$archivos = Input::file('archivos');
			try {
				foreach($archivos as $archivo) {
					$real_name = $archivo->getClientOriginalName();
					$ext = explode('.', $real_name);
					$ext = strtolower(end($ext));
					$static_name = str_random(60).'.'.$ext;
					if(in_array($ext, $allows)) {
						$archivo->move(public_path().DIRECTORY_SEPARATOR.'documents', $static_name);
						$file = new Archivo;
						$file->nombre_statico = $static_name;
						$file->nombre_real = $real_name;
						$file->save();
						$files[] = $file;
					} else {
						$propuesta->delete();
						array_map(function($el){ $el->delete();}, $files);
						return Redirect::route('propuestas')->with('message', 'No se pudo hacer el registro, no se permiten archivos .'.$ext);
					}
				} 
			} catch(Exception $e) {
				return Redirect::route('propuestas')->with('message', 'Error: '.$e->getMessage());
			}
			$propuesta->archivos()->saveMany($files);
			return Redirect::route('home')->with('message', 'Propuesta registrada con éxito');
		}
	}

	public function postContacto() {
		$validator = Validator::make(Input::all(), array(
			'nombre' => 'required',
			'email' => 'required|email',
			'mensaje' => 'required'
		));

		if($validator->fails()) {
			return Redirect::route('contacto')->withErrors($validator)->withInput();
		} else {
			$nombre = Input::get('nombre');
			$email = Input::get('email');
			$mensaje = Input::get('mensaje');
			Mail::send('emails.contact.contact', array('mensaje' => $mensaje, 'nombre' => $nombre, 'email' => $email), function($message) use($nombre) {
				$message->to('def.serch@gmail.com', $nombre)->subject('Contacto desde el sitio | IPN con-ciencia');
			});
			return Redirect::route('home')->with('message', 'Mensaje enviado con éxito, pronto nos pondremos en contacto contigo');
		}
	}

}