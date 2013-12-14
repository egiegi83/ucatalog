<?php

class RicercatorePartecipaProdotto extends Eloquent {

	/**
	 *--------------------------------------------------------------------------------------
	 *RicercatorePartecipaProdotto Model
	 *--------------------------------------------------------------------------------------
	 *
	 *	Questo model rappresenta la relazione RicercatorePartecipaProdotto ed è collegato 
	 *	alla tabella del database che memorizza i Ricercatori che partecipano ai Prodotti 
	 *	presenti nel sistema.
	 *
	 */

	/**
	 * Specifica la tabella usata dal modello.
	 * @var string
	 */
	protected $table = 'ricercatore_partecipa_prodotto';
	
	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;

	/**
	 * Relazione: ogni Ricercatore è associato al Prodotto a cui partecipa.
	 * @return mixed
	 */
	public function prodotto() {
		return $this->hasOne('Prodotto', 'prodotto_id');
	}

	/**
	 * Relazione: ogni Prodotto è associato al Ricercatore che vi partecipa.
	 * @return mixed
	 */
	public function ricercatore() {
		return $this->belongsTo('Ricercatore', 'ricercatore_id');
	}

	/**
	 * Resituisce il nome del Ricercatore non riconosciuto dal DB.
	 * @return string
	 */
	public function getCoautore() {
		return $this->coautore;
	}
	/**
	 * Resituisce il Ricercatore.
	 * @return int
	 */
	public function getRicercatoreId() {
		return $this->ricercatore_id;
	}
	
	/**
	 * Resituisce prodotto.
	 * @return int
	 */
	public function getProdottoId() {
		return $this->prodotto_id;
	}

	/**
	 * Setta il ricercatore come stringa (non riconosciuto nel DB).
	 * @param string
	 */
	public function setCoautore($coautore) {
		$this->coautore = $coautore;
	}

	/**
	 * Setta il ricercatore.
	 * @param int
	 */
	public function setRicercatoreId($id) {
		$this->ricercatore_id = $id;
	}
	
	/**
	 * Setta il prodotto.
	 * @param int
	 */
	public function setProdottoId($id) {
		$this->prodotto_id = $id;
	}

}

?>
