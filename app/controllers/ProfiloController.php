<?php

class ProfiloController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Profilo controller
	|--------------------------------------------------------------------------
	|
	|
	*/
	public function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('ricercatore');
	}

	public function getIndex(){
		return View::make('layout.dashboard');
	}
	
	public function getTimeline($nome,$cognome,$ricercatore_id){	
		$ricercatore = Ricercatore::find($ricercatore_id);
		if($ricercatore->tipo < 1 && $ricercatore->tipo > 3)
			return Redirect::to('/');
		
		echo "1";
		echo $ricercatore->utente->tipo;
		echo "2";
		echo Ricercatore::typeToModel($ricercatore->tipo);
		exit;
		
		if($ricercatore->tipo != 1)
			$ricercatore = call_user_func(array($ricercatore, Ricercatore::typeToModel($ricercatore->tipo)));
		
		var_dump($ricercatore);
		return View::make('layout.timeline')
									->with('ricercatore',$ricercatore);
	}
	
	public function getProdotti(){
		$prodotti=Prodotto::where('ricercatore_id','=',Auth::getUser()->ricercatore->id)->orWhereIn('id',function($query){
            $query->select('prodotto_id')
                  ->from('ricercatore_partecipa_prodotto')
                  ->whereRaw('ricercatore_partecipa_prodotto.ricercatore_id = ' . Auth::getUser()->ricercatore->id);
        });
         return View::make('layout.dashboard.prodotti')
         	->with('prodotti',$prodotti->get());
	}
	
	public function getAggiungiProdotto(){
		return View::make('layout.dashboard.aggiungiProdotto');
	}
		
	public function getModifica($id){
		$prodotto = Prodotto::find($id);
		if($prodotto && $prodotto->ricercatore_id == Auth::getUser()->ricercatore->id){
			$prodotto=call_user_func(array($prodotto, Prodotto::typeToModel($prodotto->tipo)));
			return View::make('layout.dashboard.modificaProdotto')->with('prodotto',$prodotto->get()->first());
		}
		return Redirect::to('dashboard/prodotti');
	}
	
	public function postRemove(){
		return '';
	}
}
