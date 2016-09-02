<?php

/*
	Ruta a la pagina principal
 */
Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@showWelcome'
));

/*
	Ruta al listado de eventos
 */
Route::get('agenda/', array(
	'as' => 'agenda',
	'uses' => 'HomeController@showAgenda'
));
/*
	Ruta a la galaria
 */
Route::get('galeria/', array(
	'as' => 'galeria',
	'uses' => 'HomeController@showGaleria'
));
/*
	Ruta al formulario de contacto
 */
Route::get('contacto/', array(
	'as' => 'contacto',
	'uses' => 'HomeController@showContactForm'
));
/*
	Ruta al formulario del registro de propuestas
 */
Route::get('propuestas/', array(
	'as' => 'propuestas',
	'uses' => 'HomeController@showFormPropuestas'
));
/*
	Ruta para hacer logout
 */
Route::get('account/logout', array(
	'as' => 'signout',
	'uses' => 'AccountController@signOut'
));

/*
	Grupo de rutas que necesitan ser visitantes
 */
Route::group(array('before' => 'guest'), function() {
	/*
		Grupo de rutas que necesitan validación csrf
	 */
	Route::group(array('before' => 'csrf'), function() {
		/*
			Ruta que procesa el sistema de login
		 */
		Route::post('account/login', 
			array(
				'as' => 'accountSignIn',
				'uses' => 'AccountController@postSignIn'
			)
		);
		/*
			Ruta que procesa el formulario de contacto
		 */
		Route::post('contacto/', array(
			'as' => 'contacto',
			'uses' => 'HomeController@postContacto'
		));
		/*
			Ruta que procesa el formulario de propuestas
		 */
		Route::post('propuestas/', array(
			'as' => 'propuestas',
			'uses' => 'HomeController@savePropuesta'
		));
	});
	/*
		Ruta que muestra el formulario de login
	 */
	Route::get('account/login',
		array(
			'as' => 'accountSignIn',
			'uses' => 'AccountController@getSignIn'
		)
	);
});

/*
	Grupo de rutas que necesitan autentificación
 */
Route::group(array('before' => 'auth'), function() {
	/*
		Ruta que muestra la pagina principal del sistema de administración
	 */
	Route::get('admin/home',
		array(
			'as' => 'adminHome',
			'uses' => 'AdminController@getHome'
		)
	);

	Route::get('admin/events',
		array(
			'as' => 'adminEventos',
			'uses' => 'AdminController@getEventos'
		)
	);

	Route::group(array('prefix' => 'admin'), function() {
		Route::resource('event', 'EventController');
		Route::post('admin/gallery/addImages', array(
			'as' => 'gallery.addImages',
			'uses' => 'GalleryController@addImages'
		));
		Route::resource('gallery', 'GalleryController');
	});

	Route::get('admin/propuestas',
		array(
			'as' => 'AdminPropuestas',
			'uses' => 'AdminController@getPropuestas'
		)
	);

	Route::get('admin/galeria',array(
		'as' => 'AdminGaleria',
		'uses' => 'GalleryController@showView'
	));

	Route::group(array('before' => 'csrf'), function() {
	});
});