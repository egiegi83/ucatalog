<?php

class AccountController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Account Controller c
	|--------------------------------------------------------------------------
	|
	|	Questo controller consente la creazione, la modifica e la cancellazione
	|	di nuovi utenti nel sistema.
	|
	*/

	
	public function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('admin');
	}
	
	public function getIndex(){
		return View::make('layout.admin.home');
	}
	
	/**
	 * Aggiunge L'utente Corrente nella base di dati.
	 *
	 * @return boolean
	 */
	public function postAggiungiAccount (){
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|min:4|max:20',
			'password_confirmation' => 'required|same:password',
			'nome' => 'required|min:3',
			'cognome' => 'required|min:3',
			'data_giorno' => 'required',
			'data_mese' => 'required',
			'data_anno' => 'required',
			'amministratore' => '',
			'responsabilevqr' => '',
			'ricercatore' => '',
			'grado' => ''
		);
		
		//Prelevo tutti i dati dalle Input
		$email = Input::get('email');
		$password = Input::get('password');
		$password2 = Input::get('password_confirmation');
		$nome = Input::get('nome');
		$cognome = Input::get('cognome');
		$data_giorno = Input::get('data_giorno');
		$data_mese = Input::get('data_mese');
		$data_anno = Input::get('data_anno');
		$amministratore = Input::get('amministratore');
		$responsabilevqr = Input::get('responsabilevqr');
		$ricercatore = Input::get('ricercatore');
		$grado = Input::get('grado');
		
		//faccio il controllo con il Validator
		$validator = Validator::make(Input::all(), $rules);
		if($validator->fails()){
			return Redirect::to('admin')
				->withErrors($validator)	
				->withInput(Input::all());
		}
				
		if(($amministratore == true) && ($ricercatore == true || $responsabilevqr == true)) //controllo grado 1
			return Redirect::to('admin')
				->with('gradeError', 'non può essere contemporaneamente Amministratore e (Ricercatore o ResponsabileVQR)')
				->withInput(Input::except('amministratore','responsabilevqr','ricercatore','grado'));
				
		if($amministratore == false && $ricercatore == false && $responsabilevqr == false) //controllo grado 2
			return Redirect::to('admin')
				->with('gradeError', 'L\'utente deve avere una specializzazione')
				->withInput(Input::except('amministratore','responsabilevqr','ricercatore','grado'));
		
		if($ricercatore == false && $grado > 0)//controllo grado 3
			return Redirect::to('admin')
				->with('gradeError', 'non può essere Specializzato senza essere un ricercatore')
				->withInput(Input::except('grado'));
		
		
		if(!isset($amministratore)) $amministratore = false;
		
		//tutti i test passati, creiamo l'utente.


		//controllo grado e dataDiNascita
		$dataDiNascita = $data_giorno.'/'.$data_mese.'/'.$data_anno;
		if($amministratore == true){
			$gradoToString = 'Amministratore';
			
		} else {
			if($responsabilevqr == true){ 
				$gradoToString = 'ResponsabileVQR'; //ResponsabileVQR
				
				//deve esistere il model ResponsabileVQR
			}
			if($ricercatore == true){
				 $gradoToString = (isset($gradoToString)) ? $gradoToString.', Ricercatore' : 'Ricercatore'; //Ricercatore
				 
			}
			if(isset($grado))
			switch($grado){ //Ricercatore + (DirettoreDipartimento | ResponsabileAreaScientifica)
				case 1: $gradoToString = $gradoToString.' -> DirettoreDipartimento'; //DirettoreDipartimento
						
						//deve esistere il model Dipartimento e DirettoreDipartimento
						break;
				case 2:	$gradoToString = $gradoToString.' -> ResponsabileAreaScientifica'; //ResponsabileAreaScientifica
						
						//deve esistere il model AreaScientifica e ResponsabileAreaScientifica
						break;
			}
		}
		
		//creiamo l'oggetto objDataDiNascita per il database
		$objDataDiNascita = new DateTime();
		$objDataDiNascita->setDate(intval($data_anno), intval($data_mese), intval($data_giorno));
		
		//creiamo l'utente
		$myUser = new User();
		$myUser->setAll($email, $password, $nome, $cognome, $objDataDiNascita, $amministratore);//settiamo i campi utente
		$myUser->save(); //salviamo l'utente
		
		return Redirect::to('createduser')
			->with('email',$email)
			->with('password',$password)
			->with('nome',$nome)
			->with('cognome',$cognome)
			->with('dataDiNascita',$dataDiNascita)
			->with('grado',$gradoToString);
	}
		
		
	public function editUser (){

	}
	
	/**
	 * Elimina L'utente Corrente dalla base di dati.
	 *
	 * @return boolean
	 */
	public function deleteUser (){
		
	}
	
}
