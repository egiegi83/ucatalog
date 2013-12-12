<?php

class Ricercatore extends Eloquent{
	/*
	|------------------------------------------------------------------------------
	| Ricercatore Model
	|------------------------------------------------------------------------------
	|
	|	Questo model rappresenta l'entità Ricercatore ed è collegato alla 
	|	tabella del database dove sono memorizzati tutti i ricercatori del sistema.
	|
	*/
	
	/**
	 * La tabella del database usata dal modello
	 * @var string
	 */
	protected $table = 'ricercatori';
	
	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;
	
	/**
	*	Relazione: ogni ricercatore può essere proprietario di diversi prodotti.
	*	@return mixed
	*/
	public function prodotti()
	{
		return $this->hasMany('Prodotto');
	}

	/**
	*	Relazione: ogni ricercatore è un utente.
	*	@return mixed
	*/
	public function utente()
	{
		return $this->belongsTo('User');
	}
	
	/**
	*	Relazione: ogni direttore di dipartimento è un ricercatore.
	*	@return mixed
	*/
	public function direttore()
	{
		return $this->hasOne('DirettoreDiDipartimento', 'ricercatore_id');
	}

	/**
	*	Relazione: ogni direttore di dipartimento è un ricercatore.
	*	@return mixed
	*/
	public function responsabile()
	{
		return $this->hasOne('ResponsabileAreaScientifica', 'ricercatore_id');
	}
	
	/**
	*	Relazione: ogni direttore di dipartimento appartiene ad un dipartimento.
	*	@return mixed
	*/
	public function dipartimento()
	{
		return $this->hasOne('Dipartimento', 'dipartimento_id');
	}
	
	/**
	*	Restituisce il ruolo del ricercatore.
	*	@return mixed
	*/
	public function getRuolo()
	{
		return $this->ruolo;
	}
	
	/**
	*	Modifica il ruolo del ricercatore.
	*	@return mixed
	*/
	public function setRuolo($ruolo)
	{
		return $this->ruolo=$ruolo;
	}
		
}