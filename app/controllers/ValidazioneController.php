<?php

class ValidazioneController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Validazione controller
	|--------------------------------------------------------------------------
	|	Questo controller di occupa della validazione dei prodotti.
	|	Possono essere validati solo i prodotti con 'is_definitivo' = 1
	|	
	|	(la cosa più importante per un programmatore (dopo il codice) sono i commenti)
	|	completa il codice con i commenti! (come al costruttore)
	*/
	
	
	/**
	*	Costruttore: questo controller viene richiamato solo se 
	*	le condizioni all'interno del costruttore sono verificare (filter.php)
	*/
	public function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('validazione'); //se responsabile area scientifica o direttore
	}

	/**
	*	Restituisce la view con la lista di tutti i prodotti da validare
	*
	*	@return mixed
	*/
	public function getListaProdotti(){
		//se Direttore di Dipartimento
		if(Auth::getUser()->tipo=='2'){
			$prodotti=Prodotto::where('validazione','0')
							->where('is_definitivo','1')
							->where('dipartimento_id',
								Auth::getUser()->ricercatore()->first()
								->direttore()->first()->dipartimento_id)->get();
		}
		//se Responsabile Area Scientifica
		else{
			$prodotti=Prodotto::where('validazione','1')
							->where('is_definitivo','1')
							->where('area_scientifica_id',
								Auth::getUser()->ricercatore()->first()
									->responsabile()->first()->area_scientifica_id)->get();
		}
		return View::make('layout.dashboard.lista_validazione')->with('prodotti', $prodotti);
	}
	
	/**
	 * 	Valida il prodotto
	 *	
	 *
	 *	Come mai fai di nuovo tutti i controlli sul prodotto? 
	 *	Non visualizzava già solo i prodotti definitivi, di quel dipartimento (o area) ecc.
	 *	Se è perché puoi sempre passare l'id di un qualsiasi prodotto all'URL, non puoi farlo
	 *	con il POST? xD 
	 */
	public function getValida($id=null){
		$prodotto=Prodotto::find($id);
		//se il prodotto non è stato trovato
		if(!$prodotto)
			return Redirect::to('valida/lista-prodotti');
		
		//se Direttore di Dipartimento
		if(Auth::getUser()->tipo=='2'){
			if(($prodotto->validazione=='0')
				&&($prodotto->is_definitivo=='1')
				&&($prodotto->dipartimento_id==Auth::getUser()->ricercatore()->first()
					->direttore()->first()->dipartimento_id))
				
					$prodotto->setValidazione(1);
			else
				return Redirect::to('valida/lista-prodotti');
		}
		//se Responsabile Area Scientifica
		else{
			if(($prodotto->validazione=='1')
				&&($prodotto->is_definitivo=='1')
				&&($prodotto->area_scientifica_id==Auth::getUser()->ricercatore()->first()
					->responsabile()->first()->area_scientifica_id))
				
					$prodotto->setValidazione(2);
			else
				return Redirect::to('valida/lista-prodotti');
		}
		$prodotto->update();
		return Redirect::to('valida/lista-prodotti');
	}
}
