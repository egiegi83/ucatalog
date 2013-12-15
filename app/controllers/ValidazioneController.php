<?php

class ValidazioneController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Validazione controller
	|--------------------------------------------------------------------------
	|
	|
	*/
	public function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('validazione'); //se responsabile area scientifica o direttore
	}

//Restituisce la view con la lista di tutti i prodotti da validare
	public function getListaProdotti(){
		if(Auth::getUser()->tipo=='2'){//se Direttore di Dipartimento
			$prodotti=Prodotto::where('validazione','0')
							->where('is_definitivo','1')
							->where('dipartimento_id',Auth::getUser()->ricercatore()->first()->direttore()->first()->dipartimento_id)
							->get();
		}else{//se Responsabile Area Scientifica*/
			$prodotti=Prodotto::where('validazione','1')
							->where('is_definitivo','1')
							->where('area_scientifica_id',Auth::getUser()->ricercatore()->first()->responsabile()->first()->area_scientifica_id)
							->get();
		}
		return View::make('layout.dashboard.lista_validazione')->with('prodotti', $prodotti);
	}
	
	//Valida il prodotto
	public function getValida($id=null){
		$prodotto=Prodotto::find($id);
		if(!$prodotto)	//se il prodotto non è stato trovato
			return Redirect::to('valida/lista-prodotti');
		
		if(Auth::getUser()->tipo=='2'){//se Direttore di Dipartimento
			if(($prodotto->validazione=='0')&&($prodotto->is_definitivo=='1')&&($prodotto->dipartimento_id==Auth::getUser()->ricercatore()->first()->direttore()->first()->dipartimento_id))
				$prodotto->setValidazione(1);
			else
				return Redirect::to('valida/lista-prodotti');
		}else{ //se Responsabile Area Scientifica
			if(($prodotto->validazione=='1')&&($prodotto->is_definitivo=='1')&&($prodotto->area_scientifica_id==Auth::getUser()->ricercatore()->first()->responsabile()->first()->area_scientifica_id))
				$prodotto->setValidazione(2);
			else
				return Redirect::to('valida/lista-prodotti');
		}
			
		$prodotto->update();
		
		return Redirect::to('valida/lista-prodotti');
	}
}
