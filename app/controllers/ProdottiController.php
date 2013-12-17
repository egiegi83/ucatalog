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
	
	public static function getListaProdotti($order_name = 'data_inserimento',$order_type = 'ASC',$limit=30,$lastid=0){
		return Prodotto::where('id','>',$lastid)->orderBy($order_name,$order_type)->take($limit)->get();
	}
	
	/**
	* Elimina i prodotti selezionati da un ricercatore nella view 'dashboard/prodotti'
	*/
	public function postEliminaProdottiSelezionati(){
		$ids=Input::get('data');
		foreach($ids as $id){
			$this->EliminaProdotto($id);			
		}
	}
	
	/**
	* Elimina un singolo prodotto del ricercatore loggato ed i relativi file salvati sul Filesystem
	* @params id: identity del prodotto da eliminare
	*/
	private function EliminaProdotto($id){
		$p=Auth::getUser()->ricercatore->prodottiBozza()->find($id);
		$sps=$p->allegatiProdotto;
		foreach($sps as $sp){
			$url=$sp->getURL();
			if(File::exists($url)) File::delete($url);
		}
		$p->delete();
	}
	
	/**
	*
	*/
	public function postRimuoviAllegato(){
		$id=Input::get('ra');
		$ap=AllegatoProdotto::find($id);
		$p = Auth::getUser()->ricercatore->prodottiBozza()->find($ap->prodotto_id);
		if($p){
			$url=$ap->getURL();
			if(File::exists($url)) File::delete($url);
			$ap->delete();
		}
	}
	
	
	/**
	* Modifica di un prodotto
	* @param id: Identity del prodotto da modificare
	*/
	public function postModificaProdotto($id){
		$product= Prodotto::find($id);
		
		// Controllo se il prodotto esiste e se appartiene al ricercatore connesso
		if(!$product ||  !$product->ricercatore_id == Auth::getUser()->ricercatore->id){
			return Redirect::to('dashboard/modifica/'.$id);
		}
		
		if(Input::has('save_def')) {
			$is_def=1;
			$validator =  Validator::make(Input::all(), $this::getAllRules($product->tipo));
		} else if(Input::has('update_boz')){
			$is_def=0;
			$validator = Validator::make(Input::all(), $this::getBasicRules(true));
		} else if(Input::has('del_boz')){
			$this->EliminaProdotto($id);
			return Redirect::to('dashboard/prodotti');
		} else { 
			return Redirect::to('dashboard/modifica/'.$id); 
		}
		
		$inputAll=Input::all();
		if ($validator->fails()) { 
			return Redirect::to('dashboard/modifica/'.$id)
				->withErrors($validator) 
				->withInput($inputAll); 
			exit;
		}
		
		$product->setTitolo($inputAll['titolo']);
		$product->setDescrizione($inputAll['descrizione']);
		$product->setIsDefinitivo($is_def);
		$product->setDataPubblicazione($inputAll['data_p_year'].'-'.$inputAll['data_p_month'].'-'.$inputAll['data_p_day']);
		$product->area_scientifica_id=($inputAll['area_di_ricerca']);
		$product->dipartimento_id=Auth::getUser()->ricercatore->dipartimento_id;
		$product->ricercatore_id=Auth::getUser()->ricercatore->id;
		$product->save();
		
		switch ($product->getTipo()) {
			case 'articoli_su_rivista':
				$rivista = $product->ArticoloSuRivista;
				$rivista->setTitoloRivista($inputAll['titolo_rivista']);
				$rivista->setISSN((strlen($inputAll['issn'])>0 ? $inputAll['issn'] : 0));
				$rivista->setPaginaIniziale($inputAll['pagina_iniziale']);
				$rivista->setPaginaFinale($inputAll['pagina_finale']);
				$rivista->setNumeroRivista((strlen($inputAll['numero_rivista']) > 0 ? $inputAll['numero_rivista'] : 0));
				$rivista->setDOI((strlen($inputAll['doi'])>0 ? $inputAll['doi'] : 0));
				$rivista->setEditore($inputAll['editore']);
				$rivista->prodotto_id=$product->id;
				$rivista->save();
				break;
			case 'libri':
				$libro = $product->Libro;
				$libro->setPaginaIniziale($inputAll['pagina_iniziale']);
				$libro->setPaginaFinale($inputAll['pagina_finale']);
				$libro->setDOI((strlen($inputAll['doi'])>0 ? $inputAll['doi'] : 0));
				$libro->setTitoloLibro($inputAll['titolo_libro']);
				$libro->setISBN((strlen($inputAll['isbn'])>0 ? $inputAll['isbn'] : 0));
				$libro->setEditore($inputAll['editore']);
				$libro->prodotto_id = $product->id;
				$libro->save();
				break;
			case 'convegni':
				$convegno = $product->Convegno;
				$convegno->setPaginaIniziale($inputAll['pagina_iniziale']);
				$convegno->setPaginaFinale($inputAll['pagina_finale']);
				$convegno->setDOI((strlen($inputAll['doi'])>0 ? $inputAll['doi'] : 0));
				$convegno->setISBN((strlen($inputAll['isbn'])>0 ? $inputAll['isbn'] : 0));
				$convegno->setEditore($inputAll['editore']);
				$convegno->setDataConvegno($inputAll['data_con_year'].'-'.$inputAll['data_con_month'].'-'.$inputAll['data_con_day']);
				$convegno->setLuogoConvegno($inputAll['luogo_convegno']);
				$convegno->setNomeConvegno($inputAll['nome_convegno']);
				$convegno->prodotto_id = $product->id;
				$convegno->save();
				break;
			case 'brevetti':
				$brevetto = $product->Brevetto;
				$brevetto->prodotto_id = $product->id;
				$brevetto->save();
				break;
			case 'traduzioni':
				$traduzione = $product->Traduzione;
				$traduzione->setLingua($inputAll['lingua']);
				$traduzione->prodotto_id = $product->id;
				$traduzione->save();
				break;
			case 'altri_prodotti':
				$altra = $product->AltroProdotto;
				$altra->setAltraTipologia($inputAll['altra_tipologia']);
				$altra->prodotto_id = $product->id;
				$altra->save();
				break;
		}
		
		// elimino i vecchi coautori
		$rpp = $product->RicercatorePartecipaProdotto;
		foreach($rpp as $r){ $r->delete(); }
		
		if(Input::has('autori')){
			$autori=json_decode(Input::get('autori'))->data;
			foreach($autori as $a){
				$rpp = new RicercatorePartecipaProdotto;
				$rpp->setProdottoId($product->id);
				if(intval($a)) {
					$rpp->setRicercatoreId($a);
					$utente = Ricercatore::find($a)->utente()->first();
					$nome = $utente->getNome();
					$cognome = $utente->getCognome();
					$rpp->setCoautore($nome . " " . $cognome);
				} else {
					$rpp->setCoautore($a);
				}
				$rpp->save();
			}
		}
		
		$this->salva_allegati($product->id);
		return Redirect::to('dashboard/prodotti');
	}

	public function postAggiungi(){
		if(Input::has('save_def')) {
			$is_def=1;
			$validator =  Validator::make(Input::all(), $this::getAllRules());
		} else if(Input::has('save_boz')){
			$is_def=0;
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
		$product->setIsDefinitivo($is_def);
		$product->setDataPubblicazione($inputAll['data_p_year'].'-'.$inputAll['data_p_month'].'-'.$inputAll['data_p_day']);
		$product->area_scientifica_id=($inputAll['area_di_ricerca']);
		$product->dipartimento_id=Auth::getUser()->ricercatore->dipartimento_id;
		$product->ricercatore_id=Auth::getUser()->ricercatore->id;
		$product->setTipo($inputAll['tipo']);
		
		$product->save();

		switch ($inputAll['tipo']) {
			case 'articoli_su_rivista':
				$rivista = new ArticoloSuRivista;
				$rivista->setTitoloRivista($inputAll['titolo_rivista']);
				$rivista->setISSN((strlen($inputAll['issn'])>0 ? $inputAll['issn'] : 0));
				$rivista->setPaginaIniziale($inputAll['pagina_iniziale']);
				$rivista->setPaginaFinale($inputAll['pagina_finale']);
				$rivista->setNumeroRivista((strlen($inputAll['numero_rivista']) > 0 ? $inputAll['numero_rivista'] : 0));
				$rivista->setDOI((strlen($inputAll['doi'])>0 ? $inputAll['doi'] : 0));
				$rivista->setEditore($inputAll['editore']);
				$rivista->prodotto_id=$product->id;
				$rivista->save();
				break;
			case 'libri':
				$libro = new Libro;
				$libro->setPaginaIniziale($inputAll['pagina_iniziale']);
				$libro->setPaginaFinale($inputAll['pagina_finale']);
				$libro->setDOI((strlen($inputAll['doi'])>0 ? $inputAll['doi'] : 0));
				$libro->setTitoloLibro($inputAll['titolo_libro']);
				$libro->setISBN((strlen($inputAll['isbn'])>0 ? $inputAll['isbn'] : 0));
				$libro->setEditore($inputAll['editore']);
				$libro->prodotto_id = $product->id;
				$libro->save();
				break;
			case 'convegni':
				$convegno = new Convegno;
				$convegno->setPaginaIniziale($inputAll['pagina_iniziale']);
				$convegno->setPaginaFinale($inputAll['pagina_finale']);
				$convegno->setDOI((strlen($inputAll['doi'])>0 ? $inputAll['doi'] : 0));
				$convegno->setISBN((strlen($inputAll['isbn'])>0 ? $inputAll['isbn'] : 0));
				$convegno->setEditore($inputAll['editore']);
				$convegno->setDataConvegno($inputAll['data_con_year'].'-'.$inputAll['data_con_month'].'-'.$inputAll['data_con_day']);
				$convegno->setLuogoConvegno($inputAll['luogo_convegno']);
				$convegno->setNomeConvegno($inputAll['nome_convegno']);
				$convegno->prodotto_id = $product->id;
				$convegno->save();
				break;
			case 'traduzione':
				$commento = new Traduzione;
				$commento->setLingua($inputAll['lingua']);
				$commento->prodotto_id = $product->id;
				$commento->save();
				break;
			case 'brevetti':
				$brevetto = new Brevetto;
				$brevetto->prodotto_id = $product->id;
				$brevetto->save();
				break;
			case 'traduzioni':
				$traduzione = new Traduzione;
				$traduzione->setLingua($inputAll['lingua']);
				$traduzione->prodotto_id = $product->id;
				$traduzione->save();
				break;
			case 'altri_prodotti':
				$altra = new AltroProdotto;
				$altra->setAltraTipologia($inputAll['altra_tipologia']);
				$altra->prodotto_id = $product->id;
				$altra->save();
				break;
		}
		
		if(Input::has('autori')){
			$autori=json_decode(Input::get('autori'))->data;
			foreach($autori as $a){
				$rpp = new RicercatorePartecipaProdotto;
				$rpp->setProdottoId($product->id);
				if(intval($a)) {
					$rpp->setRicercatoreId($a);
					$utente = Ricercatore::find($a)->utente()->first();
					$nome = $utente->getNome();
					$cognome = $utente->getCognome();
					$rpp->setCoautore($nome . " " . $cognome);
				} else {
					$rpp->setCoautore($a);
				}
				$rpp->save();
			}
		}
		
		$this->salva_allegati($product->id);
		return Redirect::to('dashboard/prodotti')->with('newid',$product->id);
	}
	
	public function salva_allegati($pid){
		$files = Input::file('allegati');
		if($files[0]){
			$path = storage_path(). '/users/' . Auth::getUser()->id;

	   		if(!file_exists($path)){
	   			if(mkdir($path,0755) == NULL)
	   				return Redirect::to('dashboard/aggiungi-prodotto')->withMessage('message','errore creazione cartella allegati utente');
	   		}
	   		
			foreach($files as $file) {
				if(!$file->isValid()) continue;
				
				$fname=$file->getClientOriginalName();
				$i=1;
				while(file_exists($path . '/' . $fname)){
					$fname = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName());
					$fname .= '-' . $i++ . '.' . $file->getClientOriginalExtension();
				}
				if($file->move($path,$fname)){
					$ap = new AllegatoProdotto;
					$ap->setNomeFile($fname);
					$ap->setURL($path . '/' . $fname);
					//$ap->setDimensione($file->getSize());
					$ap->setTipoFile($file->getClientOriginalExtension());
					$ap->setProdottoId($pid);
					$ap->save();
				}
			}
		}
	}
	
	public function getDownload($id){
		$ap=AllegatoProdotto::find($id);
		if($ap->prodotto->ricercatore->id == Auth::getUser()->ricercatore->id && file_exists($ap->getURL())){
			$ext = $ap->getTipoFIle();
				
			if($ext != 'pdf') {
				header('Content-type: octet/Application-stream');
				header('Content-Disposition: attachment; filename="' . $ap->getNomeFile() . '"');
				header('Content-Description: File Transfer');
			} else {
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="'. $ap->getNomeFile() . '"');
				header('Content-Description: Show pdf file');
				header('Accept-Ranges: bytes');
			}
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . filesize($ap->getURL()));
			
			@readfile($ap->getURL());	
			
		} else {
			return "Il file non esiste";
		}
	}
	
	// regole di base per l'inserimento di un prodotto (definitivo o bozza)
	public static function getBasicRules($reqType=false){
		$br = array('titolo' => 'required|max:40',
									'area_di_ricerca' => 'required',
									'descrizione' => 'required|max:255');
		if(!$reqType) $br['tipo'] = 'required';
		return $br;
	}
	
	// regole di base più quelle per la tipologia del prodotto scelto
	private static function getAllRules($type = false){
		$rules = ProdottiController::getBasicRules($type);
		
		$t = ($type ? $type : Input::get('tipo'));
		// regole per tipologia in un array temporaneo
		switch (Input::get('tipo')) {
			case 'articoli_su_rivista':
				$tmpr = array(
					'doi' => 'alpha_num', 
					'titolo_rivista' => 'required|max:50',
					'issn' => 'required|between:13,13',
					'pagina_iniziale_rivista' => 'max:5',
					'pagina_finale_rivista' => 'max:5',
					'numero_rivista' => 'max:8'
				);
				break;
			case 'libri':
				$tmpr = array(
					'doi' => 'alpha_num', 
					'isbn' => 'required|between:13,13',
					'titolo_libro' => 'required|max:50',
					'pagina_iniziale_libro' => 'max:5',
					'pagina_finale_libro' => 'max:5',
					'editore_libro' => 'max:20'
				);
				break;
			case 'convegni':
				$tmpr = array(
					'doi' => 'alpha_num', 
					'nome_convegno' => 'required|max:30',
					'isbn' => 'required|between:13,13',
					'pagina_iniziale' => 'max:5',
					'pagina_finale' => 'max:5',
					'luogo_convegno' => 'max:30',
					'editore_convegno' => 'max:20'
					//'data_convegno' => 'date_format:"dd/mm/YYYY"'
				);
				break;
			case 'traduzione':
				$tmpr = array('lingua' => 'required|max:20');
				break;
			case 'brevetti':
				break;
			case 'altri_prodotti':
				$tmpr = array('altra_tipologia' => 'required|max:30');		
				break;
		}
		// se settata la tipologia si aggiungono alle regole di base quelle per tipologia
		if(isset($tmpr)) foreach($tmpr as $k => $v) $rules[$k]=$v;
		
		return $rules;
	}	
}
