<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
|	I filtri di Antonio Carpinelli
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	//if (Auth::guest()) return Redirect::guest('login');
	if (Auth::guest()) return Redirect::to('/');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});



/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});





/*
|--------------------------------------------------------------------------
| admin Filter
|--------------------------------------------------------------------------
|
| The "guest" filter checks that the current user is "Amministratore". 
|
*/

Route::filter('admin', function()
{
	if (!Auth::getUser()->tipo=='0') 
		return Redirect::guest('/');
});

/*
|--------------------------------------------------------------------------
| ricercatore Filter
|--------------------------------------------------------------------------
|
| The "guest" filter checks that the current user is "Ricercatore". 
|
*/

Route::filter('ricercatore', function()
{
	if (!((Auth::getUser()->tipo=='1')||(Auth::getUser()->tipo=='2')||(Auth::getUser()->tipo=='3'))) 
		return Redirect::guest('/');
});

/*
|--------------------------------------------------------------------------
| Validazione Filter
|--------------------------------------------------------------------------
|
| The "guest" filter checks that the current user is "direttore" or "responsabile Area Scientifica". 
|	
|
*/

Route::filter('validazione', function()
{
	if (!((Auth::getUser()->tipo=='2' )||(Auth::getUser()->tipo=='3')))
		return Redirect::guest('/');
});
/*
|--------------------------------------------------------------------------
| direttore Filter
|--------------------------------------------------------------------------
|
| The "guest" filter checks that the current user is "direttore". 
|	
|
*/

Route::filter('direttore', function()
{

	if (!Auth::getUser()->tipo=='2')  
		return Redirect::guest('/');
});


/*
|--------------------------------------------------------------------------
| responsabileArea Filter
|--------------------------------------------------------------------------
|
| The "guest" filter checks that the current user is "Responsabile Area Scientifica". 
| - da aggiornare in base ai cambi al db
*/

Route::filter('responsabileArea', function()
{

	if (!Auth::getUser()->tipo=='3')  
		return Redirect::guest('/');
});

/*
|--------------------------------------------------------------------------
| responsabileVQR Filter
|--------------------------------------------------------------------------
|
| The "guest" filter checks that the current user is "Responsabile VQR". 
|- da aggiornare in base ai cambi al db
*/

Route::filter('responsabileVQR', function()
{
	if (!Auth::getUser()->tipo=='4')  
		return Redirect::guest('/');
});
