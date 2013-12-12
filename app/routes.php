<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/',function(){
	return View::make('layout.home');
});

Route::controller('user', 'AutenticazioneController');
Route::controller('dashboard', 'ProfiloController');
Route::controller('prodotti', 'ProdottiController');
Route::controller('admin', 'AccountController');

/*
Route::group(array('before' => 'auth'), function(){

	
	Route::get('/dashboard/prodotti/aggiungi','AutenticazioneController@showFormAddProdotto');
	
	Route::post('/dashboard/prodotti/salva','ProdottiController@addProdotto');
	
	//constrollo se admin
	Route::get('/admin','AutenticazioneController@showAdminHome');
	Route::post('/admin','UtentiController@addUser');
});
*/
Route::post('/search',function(){
	if (Request::ajax()){
		$query = Input::get('Cerca');	
		
		$response = Response::json(Prodotto::where('titolo','like','%'.$query.'%')->get()->toArray());
		
		$response->header('Content-Type', 'application/json');
		return $response;
	}
});

Route::post('/autori/tag',function(){
	if (Request::ajax()){
		$query = Input::get('q');	
		if(strlen(trim($query))>0){
			$response = Response::json(User::where('nome','like','%'.$query.'%')->where('ricercatore_id','<>','NULL')->get()->toArray());
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return;
	}
});

