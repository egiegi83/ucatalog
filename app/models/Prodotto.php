<?php

class Prodotto extends Eloquent {
	
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
	protected $table = 'prodotti';
	
	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;
	
	/**
	 * Relazione: ogni prodotto ha un Ricercatore proprietario.
	 * @return mixed
	 */	
	public function ricercatore() {
		
		return $this->hasOne('Ricercatore', 'id');
		
	}
	
	/**
	 * Relazione: ogni prodotto appartiene a un Dipartimento.
	 * @return mixed
	 */
	public function dipartimento() {
		
		return $this->hasOne('Dipartimento', 'id');
		
	}
	
	/**
	 * Relazione: ogni prodotto appartiene a un'Area scientifica.
	 * @return mixed 
	 */
	public function areaScientifica() {
		
		return $this->hasOne('AreaScientifica','id');
	
	}
	
	/**
	 * Relazione: ogni prodotto può avere più allegati.
	 * @return mixed
	 */
	public function allegatiProdotto() {
		return $this->hasMany('AllegatoProdotto','prodotto_id');
	}

	/**
	 * Relazione: ogni prodotto può avere dei coautori.
	 * @return mixed
	 */
	public function ricercatorePartecipaProdotto() {
		return $this->hasMany('RicercatorePartecipaProdotto','prodotto_id');
	}	
	
	/**
	 * Restituisce l'ID.
	 * @return integer
	 */
	public function getId() {

		return $this->id;

	}

	/**
	 * Restituisce lo stato.
	 * @return integer
	 */
	public function getIsDefinitivo() {

		return $this->is_definitivo;

	}

	/**
	 * Restituisce il titolo.
	 * @return string
	 */
	public function getTitolo() {

		return $this->titolo;

	}
	
	/**
	 * Restituisce la descrizione.
	 * @return string
	 */
	public function getDescrizione() {
	
		return $this->descrizione;
	
	}
	
	/**
	 * Restituisce il tipo.
	 * @return string
	 */
	public function getTipo() {

		return $this->tipo;
	
	}
	
	/**
	 * Restituisce la data di inserimento nel sistema.
	 * @return DateTime
	 */
	public function getDataInserimento() {

		return $this->data_inserimento;

	}

	/**
	 * Restituisce la data di pubblicazione.
	 * @return DateTime
	 */
	public function getDataPubblicazione() {

		return $this->data_pubblicazione;

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
	 * Restituisce il codice ISBN.
	 * @return string
	 */
	public function getISBN() {

		return $this->isbn;

	}

	/**
	 * Restituisce il numero del capitolo.
	 * @return string
	 */
	public function getNumeroCapitolo() {

		return $this->numero_capitolo;

	}

	/**
	 * Restituisce la tipologia.
	 * @return string
	 */
	public function getAltraTipologia() {

		return $this->altra_tipologia;

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
	 * Restituisce la lingua.
	 * @return string
	 */
	public function getLingua() {

		return $this->lingua;

	}

	/**
	 * Modifica lo stato.
	 * @param integer
	 */
	public function setIsDefinitivo($is_def) {

		$this->is_definitivo = $is_def;

	}

	/**
	 * Modifica il titolo.
	 * @param string
	 */
	public function setTitolo($titolo) {

		$this->titolo = $titolo;

	}
	
	/**
	 * Modifica la descrizione
	 * @param string
	 */
	public function setDescrizione($descrizione) {
	
		$this->descrizione = $descrizione;
	
	}
	
	/**
	 * Modifica il tipo.
	 * @param string
	 */
	public function setTipo($tipo) {

		$this->tipo = $tipo;
	
	}

	/**
	 * Modifica la data di pubblicazione.
	 * @param DateTime
	 */
	public function setDataPubblicazione($data_pubblicazione) {

		$this->data_pubblicazione = $data_pubblicazione;

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

	/**
	 * Modifica il codice ISBN.
	 * @param string
	 */
	public function setISBN($isbn) {

		$this->isbn = $isbn;

	}

	/**
	 * Modifica il numero del capitolo.
	 * @param string
	 */
	public function setNumeroCapitolo($numero_capitolo) {

		$this->numero_capitolo = $numero_capitolo;

	}

	/**
	 * Modifica la tipologia.
	 * @param string
	 */
	public function setAltraTipologia($altra_tipologia) {

		$this->altra_tipologia = $altra_tipologia;

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
	 * Modifica la lingua.
	 * @param string
	 */
	public function setLingua($lingua) {

		$this->lingua = $lingua;

	}
		
}

?>
