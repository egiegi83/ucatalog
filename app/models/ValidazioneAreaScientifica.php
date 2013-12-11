<?php

class ValidazioneAreaScientifica extends Eloquent {

	/**
	 *----------------------------------------------------------------------------------
	 *ValidazioneAreaScientifica Model
	 *----------------------------------------------------------------------------------
	 *
	 *	Questo model rappresenta la relazione ValidazioneAreaScientifica ed è collegato 
	 *	alla tabella del database che memorizza le validazioni di Area Scientifica dei 
	 *	Prodotti presenti nel sistema.
	 *
	 */

	/**
	 * Specifica la tabella usata dal modello.
	 * @var string
	 */
	protected $table = 'validazioni_area_scientifica';
	
	public $timestamps = false;

	/**
	 * Relazione: per essere validato dall'Area scientifica, ogni prodotto deve ricevere
	 * la validazione del Dipartimento.
	 * @return mixed
	 */
	public function validazioneDipartimento() {
		return $this->hasOne('ValidazioneDipartimento', 'validazione_dipartimento_id');
	}

	/**
	 * Relazione: ogni validazione dell'Area scientifica viene effettuata da un Responsabile
	 * di comitato di Area scientifica.
	 * @return mixed
	 */
	public function responsabileAreaScientifica() {
		return $this->hasOne('ResponsabileAreaScientifica', 'responsabile_area_scientifica_id');
	}

	/**
	 * Restituisce la data in cui è avvenuta la validazione.
	 * @return DateTime
	 */
	public function getDataValidazione() {

		return $this->data_validazione;

	}

	/**
	 * Modifica la data in cui è avvenuta la validazione.
	 * @param DateTime
	 */
	public function setDataValidazione(DateTime $data_validazione) {
		$this->data_validazione = $data_validazione;
	}

}

?>
