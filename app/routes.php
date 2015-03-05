<?php

use Carbon\Carbon;

Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@showWelcome'
));

Route::get('agenda/', array(
	'as' => 'agenda',
	'uses' => 'HomeController@showAgenda'
));

Route::get('galeria/', array(
	'as' => 'galeria',
	'uses' => 'HomeController@showGaleria'
));

Route::get('contacto/', array(
	'as' => 'contacto',
	'uses' => 'HomeController@showContactForm'
));

Route::get('propuestas/', array(
	'as' => 'propuestas',
	'uses' => 'HomeController@showFormPropuestas'
));

Route::post('propuestas/', array(
	'as' => 'propuestas',
	'uses' => 'HomeController@savePropuesta'
));


Route::get('logout', function() {
	Auth::logout();
	return Redirect::route('home');
});


Route::get('/hr', function() {
	$fecha = "2015-04-15";
	$hora_inicio = "08:15";
	$hora_fin = "16:00";
	$dt = Carbon::createFromFormat("Y-m-d H:i", $fecha.' '.$hora_fin, "America/Mexico_City");
	echo $dt->toTimeString();
	echo Hash::make('Shadow');

});

Route::group(array('before' => 'guest'), function() {
	/* Validacion CSRF */
	
	Route::group(array('before' => 'csrf'), function() {
		Route::post('account/login', 
			array(
				'as' => 'accountSignIn',
				'uses' => 'AccountController@postSignIn'
			)
		);

		Route::post('contacto/', array(
			'as' => 'contacto',
			'uses' => 'HomeController@postContacto'
		));
	});

	Route::get('account/login',
		array(
			'as' => 'accountSignIn',
			'uses' => 'AccountController@getSignIn'
		)
	);
});


Route::group(array('before' => 'auth'), function() {
	Route::get('admin/home',
		array(
			'as' => 'adminHome',
			'uses' => 'AdminController@getHome'
		)
	);

	Route::get('admin/nuevaFecha',
		array(
			'as' => 'nuevaFecha',
			'uses' => 'AdminController@getNuevaFecha'
		)
	);

	Route::group(array('before' => 'csrf'), function() {
		Route::post('admin/nuevaFecha',
			array(
				'as' => 'nuevaFecha',
				'uses' => 'AdminController@postNuevaFecha'
			)
		);
	});
});