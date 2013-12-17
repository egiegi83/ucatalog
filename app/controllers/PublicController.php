<?php

class PublicController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Public controller
	|--------------------------------------------------------------------------
	|	Controller che gestisce le operazione consentite ai visitatori:
	|	In particolare implemente le funzionalità di:
	|	- ricerca prodotti 
	|	- visualizza prodotto
	|	
	*/
	public function __construct(){
	}


	/**
	*	Visualizza i dettagli di un prodotto
	*	@return mixed
	*/
	public function getProdotto(){
		
	}

	/**
	*	Effettua la ricerca per titolo (del prodotto).
	*	@return mixed
	*/
	public function postSearch(){
		if (Request::ajax()){
			$query = Input::get('Cerca');	
			$response = Response::json(Prodotto::where('titolo','like','%'.$query.'%')->get()->toArray());		
			$response->header('Content-Type', 'application/json');
			return $response;
		}
	}
	
	/**
	*	Effettua la ricerca avanzata 
	*	(titolo,dipartimenti,area scientifica, anno, autori)
	*	@return mixed
	*/
	public function postAdvancedSearch(){
		if (Request::ajax()){
			$q = (Input::has('Cerca') ? Input::get('Cerca') : '');
				
			if($q != '')	
				$res=Prodotto::where('titolo','like','%'.$q.'%');
			else
				$res=Prodotto::where('id','>','0');
			
			$res=$res->where('is_definitivo','=','1');	// restituisce solo i prodotti definitiv
			
			if(Input::has('area_di_ricerca'))
				$res=$res->where('area_scientifica_id','=',Input::get('area_di_ricerca'));
			
			if(Input::has('dipartimento'))
				$res=$res->where('dipartimento_id','=',Input::get('dipartimento'));
			
				
			if(Input::has('anno_da') && Input::has('anno_a'))
				$res=$res->whereBetween('anno',array(Input::get('anno_da'),Input::get('anno_a')));
			
			$res=$res->get();
			
			$html=""; $n=0;
			foreach($res as $p){
				$html .= '<article class="prodotto"><header><hgroup><h1>' . $p->titolo . '</h1>';
				$html .= '<h2><a href="#">' . $p->areaScientifica()->get()->first()->nome . '</a></h2>';
				$html .= '<h3><a href="#">'. Prodotto::typeToString($p->tipo) . '</a></h3>';
				$html .= '</hgroup></header><section>' . $p->descrizione . '</section><footer>';
				$co = $p->getCoautori(); $f=false; 
				if(count($co)>0){
					$html .= '<span class="autori">';
					$html .= '<label>Autori</label>';
					foreach($co as $c){
						if($f) $html .= ',';
			 		 
			 		 	if($c['type']=='1'){
			 		 		$html .= '<a href="' . URL::to('timeline/' . 
			 		 			str_replace(' ','-',$c['coautore']) . '-'. 
			 		 			$c['id']) .'">' . $c['coautore'] . '</a>';
						} else {
							$html .= $c['coautore'];
							$f=true;
						}
						$html .= '</span>';
					}
				}
				
				if($sps=$p->allegatiProdotto){
					if($sps->count()>0){
						$html .= '<span><label>Allegati</label><ul class="allegati">';
							foreach($sps as $sp){
								$html .= '<li><a href="'. URL::to('prodotti/download/'.
									$sp->getId()) . '" target="_blank"><span class="icon allegato"></span>' . 
									$sp->getNomeFile() . '</a></span></li>';
							}
							$html .= '</ul></span>';
					}
				}
				
				$u = Ricercatore::find($p->ricercatore_id)->utente;
				$html .= '<span><label>Pubblicato</label>'; 
				$html .= 'da <a href="' . URL::to('timeline/' . 
					$u->getNome() . '-' . $u->getCognome() . '-'. 
					$p->ricercatore_id) . '">';
				$html .= $u->getNome() . ' ' . $u->getCognome() .'</a>';
				
				if(($dp = substr(date_format(date_create($p->data_pubblicazione),'d-m-Y H:i:s'),0,10)) != '01-01-2000')
					$html .= 'il ' . $dp;
	
				$html .= '</span></footer></article>';
				$n++;
			}
			//var_dump(DB::getQueryLog());
			
			$data=array('html' => $html, 'query' => $q, 'count' => $n);
			$response = Response::json($data);
			$response->header('Content-Type', 'application/json');
			
			return $response;
		}
	}
	
}
