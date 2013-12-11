<?php

class AutenticazioneController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Autenticazione controller
	|--------------------------------------------------------------------------
	|
	|	Questo controller consente il login e il logout degli utenti
	|	nel sistema.
	|
	*/
	
	public function __construct(){
		$this->beforeFilter('auth',array('except' =>'postLogin'));
		$this->beforeFilter('guest',array('only' =>'postLogin'));
	}
	
	// effettua il login nel sistema
	public function postLogin(){
		$rules = array(
			'email'    => 'required|email', // controlla se è effettivamente una email
			'password' => 'required|alphaNum|min:3' // la password deve essere alfanumerica e di min 3 caratteri
		);
		
		// valida gli input seguendo le regole definite sopra
		$validator = Validator::make(Input::all(), $rules);
		
		// se la validazione fallisce ritorna alla form di login
		if ($validator->fails()) {
			return Redirect::to('/')
				->withErrors($validator) // invia gli errori alla form di login
				->withInput(Input::except('password')); // conserva gli input immessi, eccetto la password
		} else {
			// crea un array con i dati immessi nella form
			$userdata = Input::only('email','password');
		
			// effettua il login dell'utente
			if(Auth::attempt($userdata)){
				// il login ha avuto successo
				return Redirect::to('dashboard');
			} 
			else{	 	
				// il login non ha avuto successo
				return Redirect::to('/')->with('message', 'Errore login');
			}
		}
	}
	
	// effettua il logout dal sistema
	public function postLogout(){
		Auth::logout();
		return Redirect::to('/');
	}

	
}
