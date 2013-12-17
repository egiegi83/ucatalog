<?php

class Traduzione extends Eloquent {

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
	protected $table = 'traduzioni';

	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;

	/**
	 * Relazione: ogni traduzione è un prodotto.
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
	public function getLingua() {
	
		return $this->lingua;
	
	}

	/**
	 * Modifica la lingua.
	 * @param string
	 */
	public function setLingua($lingua) {

		$this->lingua = $lingua;

	}
}

?>
