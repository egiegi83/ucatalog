<?php

class AccountController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Account Controller
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
		//Regole di controllo input
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|min:4|max:20',
			'password_confirmation' => 'required|same:password',
			'nome' => 'required|min:2',
			'cognome' => 'required|min:2',
			'data_giorno' => 'required',
			'data_mese' => 'required',
			'data_anno' => 'required',
			'seleziona_tipo' => 'required',
		);
		
		//Prelevo tutti i dati dalle Input
		$dati=Input::all();
		
		//faccio il controllo con il Validator
		$validator = Validator::make($dati, $rules);
		if($validator->fails()){
			return Redirect::to('admin')
				->withErrors($validator)	
				->withInput(Input::all());
		}
		
		//tutti i test passati, creiamo l'utente.


		//controllo dataDiNascita
		$dataDiNascita = $dati['data_giorno'].'/'.$dati['data_mese'].'/'.$dati['data_anno'];

		//creiamo l'oggetto objDataDiNascita per il database
		$objDataDiNascita = new DateTime();
		$objDataDiNascita->setDate(intval($dati['data_anno']), intval($dati['data_mese']), intval($dati['data_giorno']));
		
		
		//creiamo l'utente
		$myUser = new User();
		$myUser->setEmail($dati['email']);
		$myUser->setPassword($dati['password']);
		$myUser->setNome($dati['nome']);
		$myUser->setCognome($dati['cognome']);
		$myUser->setData($objDataDiNascita);
		$myUser->setTipo($dati['seleziona_tipo']);
		
		if($dati['seleziona_tipo']=='4'){  //se responsabileVQR
			//crea utente e ResponsabileVQR e salva nel db
			$myUser->save();
			$responsabile=new ResponsabileVQR();
			$myUser->responsabileVQR()->save($responsabile);
		}else{ 
		//se non è ResponsabileVQR
		//controllo su ruolo e diparimento
			$rules = array(
				'ruolo'    => 'required',
				'dipartimento' => 'required',
			);
			$datiRic=Input::only('ruolo','dipartimento');
			$validator = Validator::make($datiRic, $rules);
			if($validator->fails()){
				return Redirect::to('admin')
					->withErrors($validator)	
					->withInput(Input::all());
			}
			
			switch ($dati['seleziona_tipo']) {
				case '1':			//se Ricercatore
					//crea Ricercatore e salva nel db
					$ricercatore=new Ricercatore();
					$ricercatore->setDipartimento($datiRic['ruolo']);
					$ricercatore->setRuolo($datiRic['dipartimento']);
					$myUser->save();
					$myUser->ricercatore()->save($ricercatore); 
					break;
				case '2':			//se Direttore di Dipartimento
					//crea Ricercatore e DirettoreDiDipartimento e salva nel db
					$ricercatore=new Ricercatore();
					$ricercatore->setDipartimento($datiRic['dipartimento']);
					$ricercatore->setRuolo($datiRic['ruolo']);
					$myUser->save();
					$myUser->ricercatore()->save($ricercatore); 
					$direttore= new DirettoreDiDipartimento();
					$direttore->dipartimento_id=$ricercatore->dipartimento_id;
					$ricercatore->direttore()->save($direttore);
					break;
				case '3':			//se Responsabile Area Scientifica
					$rules = array(							//controllo su select Area Scientifica
						'area'    => 'required',
					);
					$datiArea=Input::only('area');					
					$validator = Validator::make($datiArea, $rules);
					if($validator->fails()){
						return Redirect::to('admin')
							->withErrors($validator)	
							->withInput(Input::all());
					}
					//cree Ricercatore e Responsabile e salva nel db
					$ricercatore=new Ricercatore();
					$ricercatore->setDipartimento($datiRic['dipartimento']);
					$ricercatore->setRuolo($datiRic['ruolo']);
					$myUser->save();
					$myUser->ricercatore()->save($ricercatore); 
					$responsabile= new ResponsabileAreaScientifica();
					$responsabile->area_scientifica_id=$datiArea['area'];
					$ricercatore->responsabile()->save($responsabile);
					break;
			}
		}
				
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
