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

}