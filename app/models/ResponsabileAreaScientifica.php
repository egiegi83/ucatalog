<?php

class ResponsabileAreaScientifica extends Eloquent{
	/*
	|----------------------------------------------------------------------------
	| Direttore di Dipartimento Model
	|----------------------------------------------------------------------------
	|
	|	Questo model rappresenta l'entità Direttore di Dipartimento ed è collegato 
	|	alla tabella del database dove sono memorizzati tutti i direttori.
	|
	*/


	/**
	 * La tabella del database usata dal modello
	 * @var string
	 */
	protected $table = 'responsabili_area_scientifica';

	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;

	/**
	*	Relazione: ogni direttore di dipartimento è un ricercatore.
	*	@return mixed
	*/
	public function ricercatore()
	{
		return $this->hasOne('Ricercatore', 'ricercatore_id');
	}	

	/**
	*	Relazione: ogni responsabile di area scientifica appartiene ad un'area scientifica.
	*	@return mixed
	*/
	public function ricercatore()
	{
		return $this->hasOne('AreaScientifica', 'area_scientifica_id');
	}	
}