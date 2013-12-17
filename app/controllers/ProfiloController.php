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
