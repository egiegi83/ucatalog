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
		return View::make('layout.dashboard.prodotti')
			->with('prodotti', Auth::getUser()->ricercatore->prodotti()->get());
	}
	
	public function getAggiungiProdotto(){
		return View::make('layout.dashboard.aggiungiProdotto');
	}
	
	public function postRemove(){
		return '';
	}
}
