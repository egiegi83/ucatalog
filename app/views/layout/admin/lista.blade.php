@extends('layout.admin.home')

@section('content.admin')
	<nav>
		<ul>
			<li><a href="{{ URL::to('admin/aggiungi-account') }}" class="btn">Crea account</a></li>
		</ul>
	</nav>
	
	
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
			<td></td>
		</tr>
		@foreach ($users as $user)
			<?php switch($user->tipo)
			{
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
		@if ($user->active == '1' && $user->tipo != '0')
			<tr><td>{{$user->cognome }}</td>
			<td>{{$user->nome }}</td><td> {{$user->email }}</td>
			<td> <?php echo $tipo; ?> </td>
			<td>
				<a href="{{ URL::to('admin/modifica/' . $user->id) }}">Modifica</a>
			</tr>
		@endif
		@endforeach
	</table>
@stop
