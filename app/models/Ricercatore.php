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
		return $this->hasMany('Prodotto','id');
	}

	/*
	*  Ritorna solo i prodotti bozza del ricercatore
	*/
	public function prodottiBozza()
	{
		return $this->prodotti()->where('is_definitivo','=','0');
	}
	/*
	* Meglio nel controller questo metodo
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
	*	Relazione: ogni responsabile è un ricercatore.
	*	@return mixed
	*/
	public function responsabile()
	{
		return $this->hasOne('ResponsabileAreaScientifica', 'ricercatore_id');
	}
	
	/**
	*	Relazione: ogni ricercatore appartiene ad un dipartimento.
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
	* Restituisce il dipartimento del Ricercatore.
	* @return string
	*/
	public function getDipartimento(){
		return $this->dipartimento_id;
	}
	
	/**
	*	Modifica il ruolo del ricercatore.
	*	@return mixed
	*/
	public function setRuolo($ruolo)
	{
		$this->ruolo=$ruolo;
	}
	
	/**
	*	Modifica il dipartimento del ricercatore.
	*	@return mixed
	*/
	public function setDipartimento($dipartimento)
	{
		$this->dipartimento_id=$dipartimento;
	}

}
