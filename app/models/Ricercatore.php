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
	
	/*
	*  Ritorna solo i prodotti bozza del ricercatore
	*/
	public function prodottiBozza()
	{
		return $this->prodotti()->where('is_definitivo','=','0');
	}
	/*
	* Ritorna solo i prodotti definitivi del ricercatore
	*/
	public function prodottiDefinitivi()
	{
		return $this->prodotti()->where('is_definitivo','=','1');
	}

	/**
	*	Relazione: ogni ricercatore è un utente.
	*	@return mixed
	*/
	public function utente()
	{
		return $this->belongsTo('User','utente_id');
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
