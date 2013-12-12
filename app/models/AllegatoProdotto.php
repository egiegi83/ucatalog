<?php

class AllegatoProdotto extends Eloquent {

	/**
	 *----------------------------------------------------------------------------------
	 *AllegatoProdotto Model
	 *----------------------------------------------------------------------------------
	 *
	 *	Questo model rappresenta l'entità AllegatoProdotto ed è collegato alla tabella del
	 *	database che memorizza gli allegati dei Prodotti all'interno del sistema.
	 *
	 */

	/**
	 * Specifica la tabella usata dal modello.
	 * @var string
	 */
	protected $table = 'allegati_prodotto';
	
	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;

	/**
	 * Relazione: ogni allegato è associato ad un prodotto.
	 * @return mixed
	 */
	public function prodotto() {
		return $this->hasOne('Prodotto', 'prodotto_id');
	}

	/**
	 * Restiuisce il nome del file.
	 * @return string
	 */
	public function getNomeFile() {
		return $this->nome_file;
	}

	/**
	 * Restiuisce l'URL del file.
	 * @return string
	 */
	public function getURL() {
		return $this->url;
	}

	/**
	 * Restiuisce la dimensione del file.
	 * @return string
	 */
	public function getDimensione() {
		return $this->dimensione;
	}

	/**
	 * Modifica il nome del file.
	 * @param string
	 */
	public function setNomeFile($nome_file) {
		$this->nome_file = $nome_file;
	}

	/**
	 * Modifica l'URL del file.
	 * @param string
	 */
	public function setURL($url) {
		$this->url = $url;
	}

	/**
	 * Modifica la dimensione del file.
	 * @param string
	 */
	public function setDimensione($dimensione) {
		$this->dimensione = $dimensione;
	}

}

?>
