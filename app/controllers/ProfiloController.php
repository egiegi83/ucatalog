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
<<<<<<< HEAD
		return View::make('layout.dashboard.prodotti')
			->with('prodotti', Auth::getUser()->ricercatore->prodotti()->get());
=======
		$utente = Auth::getUser();
		$ricercatore = Auth::getUser()->ricercatore()->get()->first();
		$prodotti = Prodotto::where('ricercatore_id','=',$ricercatore->id);
		return View::make('layout.dashboard.prodotti')->with('prodotti',$prodotti->get());
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
	}
	
	public function getAggiungiProdotto(){
		return View::make('layout.dashboard.aggiungiProdotto');
	}
<<<<<<< HEAD
	
=======
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
	public function postRemove(){
		return '';
	}
}
