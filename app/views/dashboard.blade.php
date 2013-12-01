<!doctype html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<title>uCatalog</title>
	</head>
<body>
	<div>
		Lista di prodotti dell'utente {{ $utente->nome . " " . $utente->cognome}}:
		@foreach ($prodotti as $prodotto)
			<p> 
				{{ "Titolo: " . $prodotto->titolo . "</br>" 
				. "Descrizione: ". $prodotto->descrizione }}
			</p>
		@endforeach
		<p>
		<p>{{ Form::open(array('action' => 'AutenticazioneController@doLogout')) }}</p>
			<p>{{ Form::submit('log out') }}</p>
		<p>{{ Form::close() }}</p>
	</div>
</body>
</html>
