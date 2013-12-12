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
	
	public static function getListaProdotti($order_name,$order_type,$limit=30,$lastid=0){
		return Prodotto::where('prodotto_id','>',$lastid)->orderBy($order_name,$order_type)->take($limit);
	}
	
	public function postEliminaProdottiSelezionati(){
		$ids=Input::get('data');
		Auth::getUser()->ricercatore->prodottiBozza()->delete($ids);
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
		if ($validator->fails()) { 
			return Redirect::to('dashboard/aggiungi-prodotto')
				->withErrors($validator) 
				->withInput($inputAll); 
		}
		
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
					'numero_rivista' => 'required|max:8'
				);
				break;
			case 'libro':
				$tmpr = array(
					'doi' => 'alpha_num', 
					'isbn' => 'required|between:13,13',
					'pagina_iniziale_libro' => 'required|max:5',
					'pagina_finale_libro' => 'required|max:5',
					'editore_libro' => 'required|max:20'
				);
				break;
			case 'convegno':
				$tmpr = array(
					'doi' => 'alpha_num', 
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
	}	
}
