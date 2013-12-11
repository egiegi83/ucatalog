<?php

class DirettoreDiDipartimento extends Eloquent{
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
	protected $table = 'direttori_di_dipartimento';

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
	*	Relazione: ogni direttore di dipartimento appartiene ad un dipartimento.
	*	@return mixed
	*/
	public function ricercatore()
	{
		return $this->hasOne('Dipartimento', 'dipartimento_id');
	}	
}