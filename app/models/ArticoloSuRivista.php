<?php

class ArticoloSuRivista extends Eloquent {

	/**
	 * --------------------------------------------------------------------------------------------------
	 * Prodotto Model
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
	protected $table = 'articoli_su_rivista';

	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;


	/**
	 * Relazione: ogni articolo su rivista è un prodotto.
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
	 * Restituisce il codice DOI.
	 * @return string
	 */
	public function getDOI() {

		return $this->doi;
	}

	/**
	 * Restituisce il codice ISSN.
	 * @return string
	 */
	public function getISSN() {

		return $this->issn;
	}

	/**
	 * Restituisce il titolo della rivista.
	 * @return string
	 */
	public function getTitoloRivista() {

		return $this->titolo_rivista;

	}

	/**
	 * Restituisce la pagina iniziale.
	 * @return string
	 */
	public function getPaginaIniziale() {

		return $this->pagina_iniziale;

	}

	/**
	 * Restituisce la pagina finale.
	 * @return string
	 */
	public function getPaginaFinale() {

		return $this->pagina_finale;

	}

	/**
	 * Restituisce il numero della rivista.
	 * @return string
	 */
	public function getNumeroRivista() {

		return $this->numero_rivista;

	}

	/**
	 * Restituisce l'editore.
	 * @return string
	 */
	public function getEditore() {

		return $this->editore;

	}
	/**
	 * Modifica il codice DOI.
	 * @param string
	 */
	public function setDOI($doi) {

		$this->doi = $doi;

	}

	/**
	 * Modifica il codice ISSN.
	 * @param string
	 */
	public function setISSN($issn) {

		$this->issn = $issn;

	}

	/**
	 * Modifica il titolo della rivista.
	 * @param string
	 */
	public function setTitoloRivista($titolo_rivista) {

		$this->titolo_rivista = $titolo_rivista;

	}

	/**
	 * Modifica la pagina iniziale.
	 * @param string
	 */
	public function setPaginaIniziale($pagina_iniziale) {

		$this->pagina_iniziale = $pagina_iniziale;

	}

	/**
	 * Modifica la pagina finale.
	 * @param string
	 */
	public function setPaginaFinale($pagina_finale) {

		$this->pagina_finale = $pagina_finale;

	}

	/**
	 * Modifica il numero della rivista.
	 * @param string
	 */
	public function setNumeroRivista($numero_rivista) {

		$this->numero_rivista = $numero_rivista;

	}

	/**
	 * Modifica l'editore.
	 * @param string
	 */
	public function setEditore($editore) {

		$this->editore = $editore;

	}
}

?>
