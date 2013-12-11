<?php

class AreaScientifica extends Eloquent {

	/**
	 *---------------------------------------------------------------------------------------
	 *AreaScientifica Model
	 *---------------------------------------------------------------------------------------
	 *	Questo model rappresenta l'entità AreaScientifica ed è collegato alla tabella del
	 *	database nella quale sono raccolte tutte le aree scientifiche del sistema.
	 *
	 */
	
	/**
	 * Specifica la tabella usata dal modello.
	 * @var string
	 */
	protected $table = 'area_scientifica';
	
	public $timestamps = false;
	
	/**
	 * Restituisce l'ID.
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Restiuisce il nome.
	 * @return string
	 */
	public function getNome() {
		return $this->nome;
	}

	/**
	 * Modifica il nome.
	 * @param string
	 */
	public function setNome($nome) {
		$this->nome = $nome;
	}

}

?>
	
