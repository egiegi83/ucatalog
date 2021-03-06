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
		
		return $this->belongsTo('Ricercatore', 'ricercatore_id');
		
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
		
		return $this->belongsTo('AreaScientifica','area_scientifica_id');
	
	}
	
	/**
	 * Relazione: ogni prodotto può avere più allegati.
	 * @return mixed
	 */
	public function allegatiProdotto() {
		return $this->hasMany('AllegatoProdotto');
	}

	/**
	 * Relazione: ogni prodotto può avere dei coautori.
	 * @return mixed
	 */
	public function ricercatorePartecipaProdotto() {
		return $this->hasMany('RicercatorePartecipaProdotto','prodotto_id');
	}	
	
	/**
	 * Relazione: ogni prodotto può essere validato da un direttore di Dipartimento.
	 * @return mixed
	 */
	public function validazioneDipartimento() {
		return $this->hasOne('ValidazioneDipartimento','prodotto_id');
	}	
	
	/**   -----------------------------------------------------------
	*	  	Relazioni per Tipologia di prodotto
	*	  -----------------------------------------------------------
	*/
	
	/**
	 * Relazione: un prodotto può essere un articolo su rivista.
	 * @return mixed 
	 */
	public function articoloSuRivista() {
		
		return $this->hasOne('ArticoloSuRivista','prodotto_id');
	
	}
	/**
	 * Relazione: un prodotto può essere un libro.
	 * @return mixed 
	 */
	public function libro() {
		
		return $this->hasOne('Libro','prodotto_id');
	
	}

	/**
	 * Relazione: un prodotto può essere un Convegno/Atto di convegno.
	 * @return mixed 
	 */
	public function convegno() {
		
		return $this->hasOne('Convegno','prodotto_id');
	
	}

	/**
	 * Relazione: un prodotto può essere una traduzione.
	 * @return mixed 
	 */
	public function traduzione() {
		
		return $this->hasOne('Traduzione','prodotto_id');
	
	}

	/**
	 * Relazione: un prodotto può essere un brevetto.
	 * @return mixed 
	 */
	public function brevetto() {
		
		return $this->hasOne('Brevetto','prodotto_id');
	
	}

	/**
	 * Relazione: un prodotto può essere un altro tipo di prodotto (tipologia personalizzata).
	 * @return mixed 
	 */
	public function altroProdotto() {
		
		return $this->hasOne('AltroProdotto','prodotto_id');
	
	}
	
	
	/**   -----------------------------------------------------------
	*	  	Fine Relazioni per Tipologia di prodotto
	*	  -----------------------------------------------------------
	*/
	
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
	 * Restituisce il livello di validazione del prodotto.
	 * @param string
	 */
	public function getValidazione() {
	
		return $this->validazione;
	
	}
	
	public function getCoautori(){
		$co = array();
		$rpps=$this->ricercatorePartecipaProdotto;
  	  	if($rpps){	
  	  		foreach($rpps as $rpp){
  	  			$c = array();
		 		 if($rpp->ricercatore_id){
		 		 	$c['type'] = 1;
		 		 	$c['id'] = $rpp->ricercatore_id;
		 		 	$u = $rpp->ricercatore->utente; 
		 		 	$c['coautore'] = $u->nome . ' ' . $u->cognome;
	 		 	} else {
					$c['type'] = 0;
		 		 	$c['coautore'] = $rpp->coautore;
				}
				$co[] = $c;
			}
		}
		return $co;
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
	 * Modifica il livello di validazione del prodotto.
	 * @param string
	 */
	public function setValidazione($validazione) {
		$this->validazione = $validazione;
	}
	
	/**
	*	Ritorna il nome della tabella nel nome del Model
	*/
	public static function typeToModel($type){
		switch($type){
			case 'articoli_su_rivista':
					return 'ArticoloSuRivista';
				break;
			case 'libri':
				return 'Libro';
				break;
			case 'convegni':
			return 'Convegno';
				break;
			case 'traduzione':
			return 'Traduzione';
				break;
			case 'brevetti':
				return 'Brevetto';
				break;
			case 'altri_prodotti':
				return 'AltroProdotto';
				break;
		}
	}
	/*
	* Ritorna il nome della tabella in un nome user-friendly
	*/
	public static function typeToString($type){
		switch($type){
			case 'articoli_su_rivista':
					return 'Articolo su rivista';
				break;
			case 'libri':
				return 'Libro';
				break;
			case 'convegni':
			return 'Convegno';
				break;
			case 'traduzione':
			return 'Traduzione';
				break;
			case 'brevetti':
				return 'Brevetto';
				break;
			case 'altri_prodotti':
				return 'Altro prodotto';
				break;
		}
	}
}

?>
