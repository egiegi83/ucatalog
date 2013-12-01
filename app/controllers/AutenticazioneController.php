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
	
	// effettua il login nel sistema
	public function doLogin(){
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
				return Redirect::to('/')->with('message', Hash::make('prova'));;
			}
		}
	}
	
	// effettua il logout dal sistema
	public function doLogout(){
		Auth::logout();
		return Redirect::to('/');
	}
	
	public function showProfile(){
		
		if( Auth::check()){
			$utente = Auth::getUser();
			$ricercatore = Auth::getUser()->ricercatore()->get()->first();
			$prodotti = Prodotto::where('ricercatore_id','=',$ricercatore->id);
			return View::make('dashboard')
			->with('utente',$utente)
			->with('prodotti',$prodotti->get());
		}
		else{
			return Redirect::to('/');
		}
		
	}

	
}