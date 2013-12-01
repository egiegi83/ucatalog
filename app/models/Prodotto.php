<?php


class Prodotto extends Eloquent{
	/*
	|--------------------------------------------------------------------------
	| Prodotto Model
	|--------------------------------------------------------------------------
	|
	|	Questo model rappresenta l'entità Prodotto ed è collegato alla tabella
	|	del database dove sono memorizzati tutti i prodotti del sistema.
	|
	*/

	
	/**
	 * La tabella del database usata dal modello
	 * @var string
	 */
	protected $table = 'prodotti';
	
	/**
	*	Relazione: ogni prodotto ha un ricercatore proprietario.
	*	@return mixed
	*/
	public function ricercatore()
	{
		return $this->hasOne('Ricercatore', 'ricercatore_id');
	}	
	
	/**
	*	Relazione: ogni prodotto appartiente ad un dipartimento.
	*	@return mixed
	*/
	public function dipartimento()
	{
		return $this->hasOne('Dipartimento', 'dipartimento_id');
	}	
	
	/**
	*	Relazione: ogni prodotto appartiente ad un'area scientifica.
	*	@return mixed
	public function areaScientifica()
	{
		return $this->hasOne('Dipartimento', 'dipartimento_id');
	}	
	*/
}