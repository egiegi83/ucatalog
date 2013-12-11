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
<<<<<<< HEAD
	
=======
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
	public function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('ricercatore');
	}
	
<<<<<<< HEAD
	public static function getListaProdottiDefinitivi($order_name,$order_type,$limit=30,$lastid=0){
		return Prodotto::where('prodotto_id','>',$lastid)->orderBy($order_name,$order_type)->take($limit);
	}
	
	public function postEliminaProdottiSelezionati(){
		$ids=Input::get('data');
		Auth::getUser()->ricercatore->prodottiBozza()->find($ids)->remove();
	}
	
	public function postModifica(){

	}

	public function postAggiungi(){
		if(Input::has('save_def')) {
			$validator =  Validator::make(Input::all(), $this::getAllRules());
		} else if(Input::has('save_boz')){
			$validator = Validator::make(Input::all(), $this::getBasicRules());
		} else { 
			return Redirect::to('dashboard/aggiungi-prodotto'); 
		}
		
		$inputAll=Input::all();
=======
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
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
		if ($validator->fails()) { 
			return Redirect::to('dashboard/aggiungi-prodotto')
				->withErrors($validator) 
				->withInput($inputAll); 
		}
<<<<<<< HEAD
		
		$product= new Prodotto;
		$product->setTitolo($inputAll['titolo']);
		$product->setDescrizione($inputAll['descrizione']);
		$product->setIsDefinitivo(0);
		$product->setTipo($inputAll['tipo']);
		$product->setDataPubblicazione($inputAll['data_p_year'].'-'.$inputAll['data_p_month'].'-'.$inputAll['data_p_day']);
		$product->setDOI((strlen($inputAll['doi'])>0 ? $inputAll['doi'] : 0));
		$product->setISSN((strlen($inputAll['issn'])>0 ? $inputAll['issn'] : 0));
		$product->setISBN((strlen($inputAll['isbn'])>0 ? $inputAll['isbn'] : 0));
		$product->setTitoloRivista($inputAll['titolo_rivista']);
		$product->setPaginaIniziale($inputAll['pagina_iniziale']);
		$product->setPaginaFinale($inputAll['pagina_finale']);
		$product->setNumeroRivista((strlen($inputAll['numero_rivista']) > 0 ? $inputAll['numero_rivista'] : 0));
		$product->setEditore($inputAll['editore']);
		$product->setNumeroCapitolo((strlen($inputAll['numero_capitolo']) > 0 ? $inputAll['numero_capitolo'] : 0));
		$product->setAltraTipologia($inputAll['altra_tipologia']);
		$product->setDataConvegno($inputAll['data_convegno']);
		$product->setLuogoConvegno($inputAll['luogo_convegno']);
		$product->setNomeConvegno($inputAll['nome_convegno']);
		$product->setLingua($inputAll['lingua']);
		$product->area_scientifica_id=($inputAll['area_di_ricerca']);
		$product->dipartimento_id=Auth::getUser()->ricercatore()->get()->first()->dipartimento_id;
		$product->ricercatore_id=Auth::getUser()->ricercatore_id;
		$product->save();
		
		return Redirect::to('dashboard/prodotti')->with('newid',$product->id);
	}
	
	
	// regole di base per l'inserimento di un prodotto (definitivo o bozza)
	public static function getBasicRules(){
		return array('titolo' => 'required|max:40',
									'area_di_ricerca' => 'required',
									'descrizione' => 'required|max:100'); 
	}
	
	// regole di base più quelle per la tipologia del prodotto scelto
	private static function getAllRules(){
		$rules = $this::getBasicRules();
		
		// regole per tipologia in un array temporaneo
		switch (Input::get('tipo')) {
			case 'rivista':
				$tmpr = array(
					'doi' => 'alpha_num', 
					'titolo_rivista' => 'required|max:50',
					'issn' => 'required|between:13,13',
					'pagina_iniziale_rivista' => 'required|max:5',
					'pagina_finale_rivista' => 'required|max:5',
=======
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
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
					'numero_rivista' => 'required|max:8'
				);
				break;
			case 'libro':
<<<<<<< HEAD
				$tmpr = array(
					'doi' => 'alpha_num', 
					'isbn' => 'required|between:13,13',
					'pagina_iniziale_libro' => 'required|max:5',
					'pagina_finale_libro' => 'required|max:5',
=======
				$rules = array(
					'titolo' => 'required|max:40',
					'doi' => 'alpha_num', 
					'descrizione' => 'required|max:100',
					'isbn' => 'required|between:13,13',
					'pagina_iniziale' => 'required|max:5',
					'pagina_finale' => 'required|max:5',
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
					'editore_libro' => 'required|max:20'
				);
				break;
			case 'convegno':
<<<<<<< HEAD
				$tmpr = array(
					'doi' => 'alpha_num', 
=======
				$rules = array(
					'titolo' => 'required|max:40',
					'doi' => 'alpha_num', 
					'descrizione' => 'required|max:100',
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
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
<<<<<<< HEAD
				$tmpr = array('lingua' => 'required|max:20');
				break;
			case 'brevetto':
				$tmpr = array('titolo' => 'required|max:40','descrizione' => 'required|max:100');
				break;
			case 'altro':
				$tmpr = array('altra_tipologia' => 'required|max:30');		
				break;
		}
		// se settata la tipologia si aggiungono alle regole di base quelle per tipologia
		if(isset($tmpr)) foreach($tmpr as $k => $v) $rules[$k]=$v;
		
		return $rules;
=======
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
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
	}	
}
