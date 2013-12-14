@extends('layout.admin.home')

@section('content.admin')
 	<?php if (Session::has('message')) {
		$message = Session::get('message');
		echo $message;
	}?>
	<h1>Lista Utenti</h1>
	<table width="1000" border="1">
		<tr>
			<td>Nome</td>
			<td>Cognome</td>
			<td>Email</td>
			<td>Tipo</td>
			<td>Modifica</td>
		</tr>
		@foreach ($users as $user)
			<?php switch($user->tipo)
			{
				case '0':
					$tipo='Amministratore';
					break;
				case "1":
					$tipo='Ricercatore';
					break;
				case "2":
					$tipo='Direttore di Dipartimento';
					break;
				case "3":
					$tipo='Responsabile Area Scientifica';
					break;
				case "4":
					$tipo='Responsabile VQR';
					break;
			}?>
			<tr><td>{{$user->cognome }}</td>
			<td>{{$user->nome }}</td><td> {{$user->email }}</td><td> <?php echo $tipo; ?> </td><td><a href="modifica/<?php echo $user->id;?>">Modifica</a></tr>
		@endforeach
	</table>
@stop
