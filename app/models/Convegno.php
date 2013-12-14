<?php

class Convegno extends Eloquent {

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
	protected $table = 'convegni';

	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;


	/**
	 * Relazione: ogni convegno è un prodotto.
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
	 * Restituisce l'editore.
	 * @return string
	 */
	public function getEditore() {

		return $this->editore;

	}

	/**
	 * Restituisce il codice ISBN.
	 * @return string
	 */
	public function getISBN() {

		return $this->isbn;

	}

	/**
	 * Restituisce la data del convegno.
	 * @return DateTime
	 */
	public function getDataConvegno() {

		return $this->data_convegno;

	}

	/**
	 * Restituisce il luogo del convegno.
	 * @return string
	 */
	public function getLuogoConvegno() {

		return $this->luogo_convegno;

	}

	/**
	 * Restituisce il nome del convegno.
	 * @return string
	 */
	public function getNomeConvegno() {

		return $this->nome_convegno;

	}

	/**
	 * Restituisce il DOI del convegno.
	 * @return string
	 */
	public function getDOI() {
	
		return $this->doi;
	
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
	 * Modifica l'editore.
	 * @param string
	 */
	public function setEditore($editore) {

		$this->editore = $editore;

	}

	/**
	 * Modifica il codice ISBN.
	 * @param string
	 */
	public function setISBN($isbn) {

		$this->isbn = $isbn;

	}

	/**
	 * Modifica la data del convegno.
	 * @param DateTime
	 */
	public function setDataConvegno($data_convegno) {

		$this->data_convegno = $data_convegno;

	}

	/**
	 * Modifica il luogo del convegno.
	 * @param string
	 */
	public function setLuogoConvegno($luogo_convegno) {

		$this->luogo_convegno = $luogo_convegno;

	}

	/**
	 * Modifica il nome del convegno.
	 * @param string
	 */
	public function setNomeConvegno($nome_convegno) {

		$this->nome_convegno = $nome_convegno;

	}
	/**
	 * Modifica il DOI del convegno.
	 * @return string
	 */
	public function setDOI($doi) {
	
		$this->doi = $doi;
	
	}


}

?>
