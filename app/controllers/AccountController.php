<?php

class AccountController extends BaseController {

	public function getSignIn() {
		return View::make('account.login');
	}

	public function postSignIn() {
		$validator = Validator::make(Input::all(), array(
			'username' => 'required|max:30',
			'password' => 'required'
		));

		if($validator->fails()) {
			return Redirect::route('accountSignIn')
							 ->withErrors($validator)
							 ->withInput();
		} else {
			$remember = (Input::has('remember')) ? true : false;
			$auth = Auth::attempt(array(
				'username' => Input::get('username'),
				'password' => Input::get('password')
			), $remember);

			if($auth) {
				return Redirect::route('adminHome');
			} else {
				return Redirect::route('accountSignIn')
								 ->withInput()
								 ->with("message", "Usuario y/o contraseña invalidos por favor verifica tus datos");

			}
		}
	}

	public function signOut() {
		Auth::logout();
		return Redirect::route('home');
	}
}
