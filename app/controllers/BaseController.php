<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	*	Restituisce un array di tutti i dipartimenti
	*	presenti nel database (mappati per ID). 
	*	utilizzato per la select nelle view di modifica e inserimento utente
	*	@return array
	*/
	public static function getDipartimenti(){
		$dipArray = array();
		$dipArray[''] = 'Seleziona dipartimento';
		foreach(Dipartimento::all() as $dipartimento){
			$dipArray[$dipartimento->getId()] = $dipartimento->getSigla() . " - " . $dipartimento->getNome(); 
		}
		return $dipArray;
	}

	/**
	*	Restituisce un array di tutte le aree di ricerca
	*	presenti nel database (mappati per ID). 
	*	utilizzato per la select nelle view di modifica e inserimento utente
	*	@return array
	*/
	public static function getAreeDiRicerca(){
		$areaArray = array();
		$areaArray[''] = 'Seleziona area di ricerca';
		foreach(AreaScientifica::all() as $area_scientifica){
			$areaArray[$area_scientifica->getId()] = $area_scientifica->getNome();
		}
		return $areaArray;
	}

}

?>