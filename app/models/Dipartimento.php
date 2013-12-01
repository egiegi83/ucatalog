<?php

class Dipartimento extends Eloquent{
	/*
	|----------------------------------------------------------------------------
	| Dipartimento Model
	|----------------------------------------------------------------------------
	|
	|	Questo model rappresenta l'entità Dipartimento ed è collegato alla tabella
	|	del database dove sono memorizzati tutti i dipartimenti.
	|
	*/


	/**
	 * La tabella del database usata dal modello
	 * @var string
	 */
	protected $table = 'dipartimenti';

}