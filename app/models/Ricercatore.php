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
<<<<<<< HEAD
=======
	
	public $timestamps = false;
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
	
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
<<<<<<< HEAD
	
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
=======
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328

	/**
	*	Relazione: ogni ricercatore è un utente.
	*	@return mixed
	*/
	public function utente()
	{
		return $this->belongsTo('User');
	}
<<<<<<< HEAD
}
=======
}
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
