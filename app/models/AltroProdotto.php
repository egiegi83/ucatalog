<?php

class AltroProdotto extends Eloquent {

	/**
	 * --------------------------------------------------------------------------------------------------
	 * Traduzione Model
	 * --------------------------------------------------------------------------------------------------
	 * 
	 *	Questo model rappresenta l'entità Prodotto ed è collegato alla tabella 
	 *	del database nella quale sono memorizzati tutti i prodotti del sistema. 
	 * 
	 */

	/**
	 * Specifica la tabella usata dal modello.
	 * @var string
	 */
	protected $table = 'altri_prodotti';

	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;


	/**
	 * Relazione: ogni altra tipologia di prodotto è un prodotto.
	 * @return mixed 
	 */
	public function prodotto() {
		
		return $this->belongsTo('Prodotto');
	
	}

		/**
	 * Restituisce l'ID.
	 * @return integer
	 */
	public function getId() {

		return $this->id;
	}

	/**
	 * Restituisce la lingua
	 * @param string
	 */
	public function getAltraTipologia() {

		return $this->altra_tipologia;

	}

	/**
	 * Modifica la lingua.
	 * @param string
	 */
	public function setAltraTipologia($altra_tipologia) {

		$this->altra_tipologia = $altra_tipologia;

	}
}

?>
