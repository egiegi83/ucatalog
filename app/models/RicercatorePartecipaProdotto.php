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
		return $this->hasOne('Ricercatore', 'ricercatore_id');
	}

	/**
	 * Resituisce il nome del Ricercatore.
	 * @return string
	 */
	public function getNome() {

		return $this->nome;

	}

	/**
	 * Resituisce il cognome del Ricercatore.
	 * @return string
	 */
	public function getCognome() {
		return $this->cognome;
	}

	/**
	 * Modifica il nome del Ricercatore.
	 * @param string
	 */
	public function setNome($nome) {
		$this->nome = $nome;
	}

	/**
	 * Modifica il cognome del Ricercatore.
	 * @param string
	 */
	public function setCognome($cognome) {
		$this->cognome = $cognome;
	}

}

?>
