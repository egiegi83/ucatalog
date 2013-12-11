<?php

class ProdottiController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Prodotti controller
	|--------------------------------------------------------------------------
	|
	|	Questo controller effettua azioni e controllo sui prodotti o sul singolo prodotto
	|
	*/
	public function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('ricercatore');
	}
	
	public function getListaProdotti($order_name,$order_type){
		return Prodotto::orderBy($order_name,$order_type)->take(30);
	}

	public function getProdottiUtente($id){
		return Prodotto::find($id);
	}
	
	public function postAggiungi(){
		if(Input::has('save_def')){
			return $this->addProdottoDefinitivo();
		} else if(Input::has('save_boz')){
			return  $this->addProdottoBozza();
		}
	}
	
	
	public function addProdottoDefinitivo(){
		$validator = $this->checkProdotto();
		$inputAll = Input::all();
		// se la validazione dei campi fallisce
		if ($validator->fails()) { 
			return Redirect::to('dashboard/aggiungi-prodotto')
				->withErrors($validator) 
				->withInput($inputAll); 
		}
		// se la validazione dei campi va a buon fine 
		else {
			$product= new Prodotto;
			$product->setTitolo($inputAll['titolo']);
			$product->setDescrizione($inputAll['descrizione']);
			$product->setIsDefinitivo(1);
			$product->setTipo($inputAll['tipo']);
			$product->setDataPubblicazione($inputAll['data_p_year'].'-'.$inputAll['data_p_month'].'-'.$inputAll['data_p_day']);
			$product->setDOI($this->checkInt($inputAll['doi']));
			$product->setISSN($this->checkInt($inputAll['issn']));
			$product->setISBN($this->checkInt($inputAll['isbn']));
			$product->setTitoloRivista($inputAll['titolo_rivista']);
			$product->setPaginaIniziale($inputAll['pagina_iniziale']);
			$product->setPaginaFinale($inputAll['pagina_finale']);
			$product->setNumeroRivista($this->checkInt($inputAll['numero_rivista']));
			if(strlen($inputAll['editore_libro'])==0)
				$product->setEditore($inputAll['editore_convegno']);
			else
				$product->setEditore($inputAll['editore_libro']);
			$product->setNumeroCapitolo($this->checkInt($inputAll['numero_capitolo']));
			$product->setAltraTipologia($inputAll['altra_tipologia']);
			$product->setDataConvegno($inputAll['data_convegno']);
			$product->setLuogoConvegno($inputAll['luogo_convegno']);
			$product->setNomeConvegno($inputAll['nome_convegno']);
			$product->setLingua($inputAll['lingua']);
			$product->area_scientifica_id=$inputAll['area_di_ricerca'];
			$product->dipartimento_id=Auth::getUser()->ricercatore()->get()->first()->dipartimento_id;
			$product->ricercatore_id=Auth::getUser()->ricercatore_id;
			$product->save();
		}
	}
	
	public function addProdottoBozza(){
		$rules = array(
			'titolo' => 'required|max:40',
			'descrizione' => 'required|max:100'
		);
		$inputAll=Input::all();		
		$validator=Validator::make($inputAll, $rules);
		
		// se la validazione dei campi fallisce
		if ($validator->fails()) { 
			return Redirect::to('dashboard/aggiungi-prodotto')
				->withErrors($validator) 
				->withInput($inputAll); 
		}
		// se la validazione dei campi va a buon fine 
		else {
			$product= new Prodotto;
			$product->setTitolo($inputAll['titolo']);
			$product->setDescrizione($inputAll['descrizione']);
			$product->setIsDefinitivo(0);
			$product->setTipo($inputAll['tipo']);
			$product->setDataPubblicazione($inputAll['data_p_year'].'-'.$inputAll['data_p_month'].'-'.$inputAll['data_p_day']);
			$product->setDOI($this->checkInt($inputAll['doi']));
			$product->setISSN($this->checkInt($inputAll['issn']));
			$product->setISBN($this->checkInt($inputAll['isbn']));
			$product->setTitoloRivista($inputAll['titolo_rivista']);
			$product->setPaginaIniziale($inputAll['pagina_iniziale']);
			$product->setPaginaFinale($inputAll['pagina_finale']);
			$product->setNumeroRivista($this->checkInt($inputAll['numero_rivista']));
			if(strlen($inputAll['editore_libro'])==0)
				$product->setEditore($inputAll['editore_convegno']);
			else
				$product->setEditore($inputAll['editore_libro']);
			$product->setNumeroCapitolo($this->checkInt($inputAll['numero_capitolo']));
			$product->setAltraTipologia($inputAll['altra_tipologia']);
			$product->setDataConvegno($inputAll['data_convegno']);
			$product->setLuogoConvegno($inputAll['luogo_convegno']);
			$product->setNomeConvegno($inputAll['nome_convegno']);
			$product->setLingua($inputAll['lingua']);
			$product->area_scientifica_id=$inputAll['area_di_ricerca'];
			$product->dipartimento_id=Auth::getUser()->ricercatore()->get()->first()->dipartimento_id;
			$product->ricercatore_id=Auth::getUser()->ricercatore_id;
			$product->save();
		}
	}
	
	
	private function checkInt($input){
		if(strlen($input) == 0 )
			return 0;
		else	
			return $input;
	}
	
	
	private function checkProdotto(){
		switch (Input::get('tipo')) {
			case 'rivista':
				$rules = array(
					'titolo' => 'required|max:40',
					'doi' => 'alpha_num', 
					'descrizione' => 'required|max:100',
					'titolo_rivista' => 'required|max:50',
					'issn' => 'required|between:13,13',
					'pagina_iniziale' => 'required|max:5',
					'pagina_finale' => 'required|max:5',
					'numero_rivista' => 'required|max:8'
				);
				break;
			case 'libro':
				$rules = array(
					'titolo' => 'required|max:40',
					'doi' => 'alpha_num', 
					'descrizione' => 'required|max:100',
					'isbn' => 'required|between:13,13',
					'pagina_iniziale' => 'required|max:5',
					'pagina_finale' => 'required|max:5',
					'editore_libro' => 'required|max:20'
				);
				break;
			case 'convegno':
				$rules = array(
					'titolo' => 'required|max:40',
					'doi' => 'alpha_num', 
					'descrizione' => 'required|max:100',
					'titolo_capitolo' => 'required|max:50',
					'isbn' => 'required|between:13,13',
					'pagina_iniziale' => 'required|max:5',
					'pagina_finale' => 'required|max:5',
					'nome_convegno' => 'required|max:30',
					'luogo_convegno' => 'max:30',
					'editore_convegno' => 'required|max:20'
				);
				break;
			case 'commento':
				$rules = array(
					'titolo' => 'required|max:40',
					'descrizione' => 'required|max:100',
					'lingua' => 'required|max:20'
				);
				break;
			case 'brevetto':
				$rules = array(
					'titolo' => 'required|max:40',
					'descrizione' => 'required|max:100'
				);
				break;
			case 'altro':
				$rules = array(
					'titolo' => 'required|max:40',
					'altra_tipologia' => 'required|max:30',
					'descrizione' => 'required|max:100'
				);		
				break;
			default:
				$rules = array('titolo' => 'required|max:40', 'descrizione' => 'required|max:100');		
				break;
		}
		return Validator::make(Input::all(), $rules);
	}	
}
