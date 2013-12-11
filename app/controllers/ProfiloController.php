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
		$utente = Auth::getUser();
		$ricercatore = Auth::getUser()->ricercatore()->get()->first();
		$prodotti = Prodotto::where('ricercatore_id','=',$ricercatore->id);
		return View::make('layout.dashboard.prodotti')->with('prodotti',$prodotti->get());
	}
	
	public function getAggiungiProdotto(){
		return View::make('layout.dashboard.aggiungiProdotto');
	}
	public function postRemove(){
		return '';
	}
}
