<?php

class Dipartimento extends Eloquent {

	/**
	 *----------------------------------------------------------------------------------
	 *Dipartimento Model
	 *----------------------------------------------------------------------------------
	 *
	 *	Questo model rappresenta l'entità Dipartimento ed è collegato alla tabella del
	 *	database che memorizza i Dipartimenti all'interno del sistema.
	 *
	 */

	/**
	 * Specifica la tabella usata dal modello.
	 * @var string
	 */
	protected $table = 'dipartimenti';
	
	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;

	/**
	 * Restituisce l'ID.
	 * @return integer
	 */
	public function getId() {

		return $this->id;

	}

	/**
	 * Restituisce il nome.
	 * @return string
	 */
	public function getNome() {

		return $this->nome;

	}
	
	/**
	 * Restituisce la sigla.
	 * @return string
	 */
	public function getSigla() {

		return $this->sigla;

	}

	/**
	 * Restituisce la descrizione.
	 * @return string
	 */
	public function getDescrizione() {

		return $this->descrizione;

	}

	/**
	 * Restituisce il numero di telefono.
	 * @return string
	 */
	public function getTelefono() {

		return $this->telefono;

	}
	
	/**
	 * Restituisce il numero di fax.
	 * @return string
	 */
	public function getFax() {

		return $this->fax;

	}

	/**
	 * Restituisce l'indirizzo.
	 * @return string
	 */
	public function getIndirizzo() {

		return $this->indirizzo;

	}

	/**
	 * Restituisce l'indirizzo email.
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Modifica il nome.
	 * @param string
	 */
	public function setNome($nome) {
		$this->nome = $nome;
	}

	/**
	 * Modifica la sigla.
	 * @param string
	 */
	public function setSigla($sigla) {
		$this->sigla = $sigla;
	}

	/**
	 * Modifica la descrizione.
	 * @param string
	 */
	public function setDescrizione($descrizione) {
		$this->descrizione = $descrizione;
	}

	/**
	 * Modifica il numero di telefono.
	 * @param string
	 */
	public function setTelefono($telefono) {
		$this->telefono = $telefono;
	}
	
	/**
	 * Modifica il numero di fax.
	 * @return boolean
	 */
	public function setFax($fax) {
		$this->fax = $fax;
	}

	/**
	 * Modifica l'indirizzo.
	 * @param string
	 */
	public function setIndirizzo($indirizzo) {
		$this->indirizzo = $indirizzo;
	}

	/**
	 * Modifica l'indirizzo email.
	 * @param string
	 */
	public function setEmail($email) {
		$this->email;
	}

}

?>
