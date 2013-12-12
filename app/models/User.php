<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	/*
	|--------------------------------------------------------------------------
	| User Model
	|--------------------------------------------------------------------------
	|
	|	Questo model rappresenta l'entità Utente ed è collegato alla tabella
	|	del database dove sono memorizzati tutti gli utenti del sistema.
	|
	*/


	/**
	 * La tabella del database usata dal modello
	 * @var string
	 */
	protected $table = 'utenti';

	/**
	* La tabella non ha un campo timestamps
	* @var boolean
	*/
	public $timestamps = false;
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	*	Relazione: ogni ricercatore è un utente.
	*	@return mixed
	*/
	public function ricercatore()
	{
		return $this->hasOne('Ricercatore','utente_id');
	}
	
	/**
	*	Relazione: ogni responsabileVQR è un utente.
	*	@return mixed
	*/
	public function responsabileVQR()
	{
		return $this->hasOne('ResponsabileVQR','utente_id');
	}
	
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	
	/**
	* Restituisce il nome.
	* @return string
	*/
	public function getNome(){
		return $this->nome;
	}
	
	/**
	* Restituisce il cognome.
	* @return string
	*/
	public function getCognome(){
		return $this->cognome;
	}
	
	/**
	* Restituisce la data di nascita.
	* @return string
	*/
	public function getDatadiNascita(){
		return $this->data_di_nascita;
	}
	
	/**
	* Restituisce il tipo d'utente.
	* @return string
	*/
	public function getTipo(){
		return $this->tipo;
	}	
	
	/**
	 * Modifica la password.
	 * @return string
	 */
	public function setPassword($password)
	{
		$this->password=Hash::make($password);
	}
	
	/**
	 * Modifica l'email.
	 * @return string
	 */
	public function setEmail($email)
	{
		$this->email=$email;
	}
	
	/**
	* Modifica il nome.
	* @return string
	*/
	public function setNome($nome){
		$this->nome=$nome;
	}
	
	/**
	* Modifica il cognome.
	* @return string
	*/
	public function setCognome($cognome){
		$this->cognome=$cognome;
	}
	
	/**
	* Modifica la data di nascita.
	* @return string
	*/
	public function setData($data){
		$this->data_di_nascita=$data;
	}
	
	/**
	* Modifica il tipo d'utente.
	* @return string
	*/
	public function setTipo($tipo){
		$this->tipo=$tipo;
	}

}