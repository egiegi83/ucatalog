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

	//Costruttore con Filtri
	public function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('admin');
	}
	
	//Restituisce la View per l'inserimento di un nuovo utente
	public function getIndex(){
		return View::make('layout.admin.home');
	}
	
	/**
	 * Aggiunge L'utente Corrente nella base di dati.
	 *
	 * @return boolean
	 */
	public function postAggiungiAccount (){
		//Prelevo tutti i dati dalle Input
		$dati=Input::all();
		//Regole di controllo input
		$rules = $this->getBasicRules($dati['seleziona_tipo']);
		
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
			switch ($dati['seleziona_tipo']) {
				case '1':			//se Ricercatore
					//crea Ricercatore e salva nel db
					$ricercatore=new Ricercatore();
					$ricercatore->setDipartimento($dati['dipartimento']);
					$ricercatore->setRuolo($dati['ruolo']);
					$myUser->save();
					$myUser->ricercatore()->save($ricercatore); 
					break;
				case '2':			//se Direttore di Dipartimento
					//crea Ricercatore e DirettoreDiDipartimento e salva nel db
					$ricercatore=new Ricercatore();
					$ricercatore->setDipartimento($dati['dipartimento']);
					$ricercatore->setRuolo($dati['ruolo']);
					$myUser->save();
					$myUser->ricercatore()->save($ricercatore); 
					$direttore= new DirettoreDiDipartimento();
					$direttore->setDipartimento($ricercatore->dipartimento_id);
					$ricercatore->direttore()->save($direttore);
					break;
				case '3':			//se Responsabile Area Scientifica
					//cree Ricercatore e Responsabile e salva nel db
					$ricercatore=new Ricercatore();
					$ricercatore->setDipartimento($dati['dipartimento']);
					$ricercatore->setRuolo($dati['ruolo']);
					$myUser->save();
					$myUser->ricercatore()->save($ricercatore); 
					$responsabile= new ResponsabileAreaScientifica();
					$responsabile->setArea($dati['area']);
					$ricercatore->responsabile()->save($responsabile);
					break;
			}
		}	
		//modificare View di return
		return 'fatto';
	}
		
	//Restituisce la view per la modifica dell'utente
	public function getModifica($id=null){
		$utente=User::where('utenti.id',$id)->first(); 
		if($utente==null) //se l'id non è presente nel DB
			return Redirect::to('admin');
			
		if($utente->tipo=='0'){ //se $utente è amministratore
			return Redirect::to('admin');
		}else{
			Switch($utente->tipo){
				case '1': //se ricercatore
					$user=User::where('utenti.id',$id)
						->Join('ricercatori', 'utenti.id', '=', 'ricercatori.utente_id')
						->first();
						return View::make('layout.admin.modifica')->with('user',$user);
						break;
				case '2': //se Direttore di Dipartimento
					$user=User::where('utenti.id',$id)
						->Join('ricercatori', 'utenti.id', '=', 'ricercatori.utente_id')
						->Join('direttori_di_dipartimento', 'ricercatori.id', '=', 'direttori_di_dipartimento.ricercatore_id')
						->first();
						return View::make('layout.admin.modifica')->with('user',$user);
						break;
				case '3': //se responsabile area scientifica
					$user=User::where('utenti.id',$id)
						->Join('ricercatori', 'utenti.id', '=', 'ricercatori.utente_id')
						->Join('responsabili_area_scientifica', 'ricercatori.id', '=', 'responsabili_area_scientifica.ricercatore_id')
						->first();
						return View::make('layout.admin.modifica')->with('user',$user);
						break;
				case '4': // se Responsabile VQR
					$user=User::where('utenti.id',$id)
						->Join('responsabili_vqr', 'utenti.id', '=', 'responsabili_vqr.utente_id')
						->first();
						return View::make('layout.admin.modifica')->with('user',$user);
						break;
				}
		}
	}
	
	//Modifica Utente nel DB
	public function postUpdate($id=null){
		$user = User::find($id);
		$inputs = Input::all();// prelevo tutti gli Input
		//Regole di controllo sugli Input
		$rules= array(
			'nome' => 'required|min:2',
			'cognome' => 'required|min:2',
			'data_giorno' => 'required',
			'data_mese' => 'required',
			'data_anno' => 'required',
			'tipo' => 'required',
		);
		if(Input::get('password')!=null){
			$rules['password'] = 'required|min:4|max:20';
			$rules['password_confirmation'] = 'required|same:password';
		}
		if(Input::get('tipo')=='1'){
			$rules['ruolo'] = 'required';
			$rules['dipartimento_id'] = 'required';
		}
		if(Input::get('tipo')=='2'){
			$rules['ruolo'] = 'required';
			$rules['dipartimento_id'] = 'required';
		}
		if(Input::get('tipo')=='3'){
			$rules['ruolo'] = 'required';
			$rules['dipartimento_id'] = 'required';
			$rules['area_scientifica_id'] = 'required';
		}
		//se la validazione degli Input fallisce reindirizza alla form di inserimento Utente
		$validator = Validator::make($inputs, $rules);
		if($validator->fails()){
			return Redirect::to('admin')
				->withErrors($validator)	
				->withInput(Input::all());
		}
		
		//creiamo l'oggetto objDataDiNascita per il database
		$objDataDiNascita = new DateTime();
		$objDataDiNascita->setDate(intval($inputs['data_anno']), intval($inputs['data_mese']), intval($inputs['data_giorno']));
		$user->setNome($inputs['nome']);
		$user->setCognome($inputs['cognome']);
		$user->setData($objDataDiNascita);
		$user->setTipo($inputs['tipo']);
		switch(Input::get('tipo')){
			case '1':
					$user->update();
					if(!$ricercatore = Ricercatore::where('utente_id',$user->id)->first()){
						$ricercatore=new Ricercatore();
					}
					$this->cancellaVecchioTipo($user->id);
					$ricercatore->setDipartimento($inputs['dipartimento_id']);
					$ricercatore->setRuolo($inputs['ruolo']);
					$user->ricercatore()->save($ricercatore);
					break;
			case '2':
					$user->update();
					if(!$ricercatore = Ricercatore::where('utente_id',$user->id)->first()){
						$ricercatore=new Ricercatore();
						$this->cancellaVecchioTipo($user->id);
					}
					$ricercatore->setDipartimento($inputs['dipartimento_id']);
					$ricercatore->setRuolo($inputs['ruolo']);
					$user->ricercatore()->save($ricercatore);
					if(!$direttore= DirettoreDiDipartimento::where('ricercatore_id',$ricercatore->id)->first()){
						$direttore=new DirettoreDiDipartimento();
						$this->cancellaVecchioTipo($user->id);
					}
					$direttore->setDipartimento($ricercatore->dipartimento_id);
					$ricercatore->direttore()->save($direttore);
					break;
			case '3':
					$user->update(); 
					if(!$ricercatore = Ricercatore::where('utente_id',$user->id)->first()){
						$ricercatore=new Ricercatore();
						$this->cancellaVecchioTipo($user->id);
					}
					$ricercatore->setDipartimento($inputs['dipartimento_id']);
					$ricercatore->setRuolo($inputs['ruolo']);
					$user->ricercatore()->save($ricercatore);
					if(!$responsabile= ResponsabileAreaScientifica::where('ricercatore_id',$ricercatore->id)->first()){
						$responsabile=new ResponsabileAreaScientifica();
						$this->cancellaVecchioTipo($user->id);
					}
					$responsabile->setArea($inputs['area_scientifica_id']);
					$ricercatore->responsabile()->save($responsabile);
					break;
			case '4':
					$user->update();
					if(!$responsabile=ResponsabileVQR::where('utente_id',$user->id)->first()){
						$responsabile=new ResponsabileVQR();
						$this->cancellaVecchioTipo($user->id);
						Ricercatore::where('utente_id',$user->id)->first()->delete();
					}
					$user->responsabileVQR()->save($responsabile);
					break;
		}
		return Redirect::to('admin'); //da cambiare o aggiungere messaggio
	}
	
	/**
	 * Elimina L'utente Corrente dalla base di dati.
	 *
	 * @return boolean
	 */
	public function postDelete (){

	}
	
	
	private function getBasicRules(){
		$rules =array(
			'email'    => 'required|email|unique:utenti,email',
			'password' => 'required|min:4|max:20',
			'password_confirmation' => 'required|same:password',
			'nome' => 'required|min:2',
			'cognome' => 'required|min:2',
			'data_giorno' => 'required',
			'data_mese' => 'required',
			'data_anno' => 'required',
			'seleziona_tipo' => 'required',
		);
		if($tipo!='4'){ //se non è ResponsabileVQR i campi ruolo e dipartimento sono obbligatori
			$rules['ruolo']= 'required';
			$rules['dipartimento'] ='required';
		}
		if($tipo=='3')// se ResponsabileAreaScientifica il campo area è obbligatorio
			$rules['area']='required';
		return $rules;
	}
		public function getTest($id){
			return $this::cancellaVecchioTipo($id);
			}
		private function cancellaVecchioTipo($id){
			$user=User::find($id);
			$ricercatore=Ricercatore::where('utente_id',$user->id)->first();
			if($ricercatore!=null){
				$direttore=DirettoreDiDipartimento::where('ricercatore_id', $ricercatore->id)->first();
				$responsabile=ResponsabileAreaScientifica::where('ricercatore_id', $ricercatore->id)->first();
			}else{
				$direttore=null;
				$responsabile=null;
			}
			$vqr=ResponsabileVQR::Where('utente_id', $user->id)->first();
			if($vqr!=null){
				$vqr->delete();
			}else{
				if($direttore!=null){
					$direttore->delete();
				}
				if($responsabile!=null){
					$responsabile->delete();
				}
			}
	}
}


