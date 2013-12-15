@extends('layout.admin.home')

@section('content.admin')
 	<?php if (Session::has('message')) {
		$message = Session::get('message');
		echo $message;
	}?>
	<h1>Lista prodotti da validare</h1>
	<table width="1000" border="1">
		<tr>
			<td>Titolo</td>
			<td>Tipo</td>
			<td>Data Pubblicazione</td>
			<td>Autore</td>
			<td>Valida</td>
		</tr>
		@foreach ($prodotti as $prodotto)
			<tr><td>{{$prodotto->titolo }}</td>
			<td>{{$prodotto->tipo }}</td>
			<td> {{$prodotto->data_pubblicazione }}</td>
			<?php $ricercatore=Ricercatore::where('id',$prodotto->ricercatore_id)->first();
				$utente=User::where('id',$ricercatore->utente_id)->first();
			?>
			<td> {{$utente->cognome ." ". $utente->nome}}</td>
			<td>
				{{ Form::open(array('url' => array('valida/valida', $prodotto->id))) }}
					{{ Form::submit('valida') }}
				{{ Form::close() }}
			</tr>
		@endforeach
	</table>
@stop
