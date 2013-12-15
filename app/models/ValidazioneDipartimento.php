<?php

class ValidazioneDipartimento extends Eloquent {

	/**
	 *-------------------------------------------------------------------------------------
	 *ValidazioneDipartimento Model
	 *-------------------------------------------------------------------------------------
	 *
	 *	Questo model rappresenta la relazione ValidazioneDipartimento ed è collegato alla 
	 *	tabella del database che memorizza le validazioni di Dipartimento dei Prodotti 
	 *	all'interno del sistema.
	 *
	 */

	/**
	 * Specifica la tabella usata dal modello.
	 * @var string
	 */
	protected $table = 'validazioni_dipartimento';
	
	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;

	/**
	 * Relazione: ogni validazione di Dipartimento è associata ad un prodotto.
	 * @return mixed
	 */
	public function prodotto() {
		return $this->hasOne('Prodotto', 'prodotto_id');
	}

	/**
	 * Relazione: ogni validazione di Dipartimento viene effettuata da un Direttore di
	 * Dipartimento.
	 * @return mixed
	 */
	public function direttoreDipartimento(){
		return $this->hasOne('DirettoreDipartimento', 'direttore_dipartimento_id');
	}

	/**
	 * Restituisce la data in cui è avvenuta la validazione.
	 * @return DateTime
	 */
	public function getDataValidazione() {
		return $this->data_validazione;
	}

}

?>
