@extends('layout.master')
@section('style')
	{{ HTML::style('css/dashboard.css'); }}
@stop

@section('script')
	{{ HTML::script('js/admin.js'); }}
@stop

@section('content')
	<nav>
		<ul>
			<li class="trall">{{ HTML::link('admin/','Dashboard') }}</li>
			<li class="trall">{{ HTML::link('admin/eventi','Eventi') }}</li>
			<li class="trall">{{ HTML::link('admin/messaggi','Messaggi') }}</li>	
	</nav>
	<section class="trall">
		<div class="trop">
		 	<?php if (Session::has('message')) {
				$message = Session::get('message');
				echo $message;
			}?>

				{{ Form::open(array('url' => 'admin/aggiungi-account')) }}</p> 
				    <p>{{ Form::label('email') }}</p>
				    {{ $errors->first('email') }}
				    <p>{{ Form::text('email', Input::old('email'), array('placeholder' => 'mail@example.com')) }}</p>
				    
				    <p>{{ Form::label('password') }}</p>
				    <p>{{ $errors->first('password') }}</p>
				    <p>{{ $errors->first('password_confirmation') }}</p>
				    <p>{{ Form::password('password') }}</p>
				    
				    <p>{{ Form::label('Retype Password') }}</p>
				    <p>{{ Form::password('password_confirmation') }}</p>
				    
				    <p>{{ Form::label('Nome') }}</p>
				    {{ $errors->first('nome') }}
				    <p>{{ Form::text('nome', Input::old('nome')) }}</p>
				    
				    <p>{{ Form::label('Cognome') }}</p>
				    {{ $errors->first('cognome') }}
				    <p>{{ Form::text('cognome', Input::old('cognome')) }}</p>
				    
				    <p>{{ Form::label('Data Di Nascita') }}</p>
				    {{ $errors->first('data') }}
				    <p>
					{{ Form::selectRange('data_giorno',1,31) }} /
					{{ Form::selectMonth('data_mese') }} /
					{{ Form::selectRange('data_anno', 1990, date('Y') ) }}
				    </p>
					<p>{{ Form::label('Seleziona tipo') }}</p>
						{{ Form::select('seleziona_tipo', array(
						'' => 'Seleziona tipo', 
						'1' => 'Ricercatore', 
						'2' => 'Direttore di Dipartimento',
						'3' => 'Responsabile Area Scientifica',
						'4' => 'Responsabile VQR',
					)) }}
					@if($errors->first('seleziona_tipo'))
						<label>{{ $errors->first('seleziona_tipo') }}</label>
					@endif
						
						<!-- se selezionato Ricercatore o Direttore Dipartimento o Responsabile Area scientifica -> Aggiungere campo Ruolo -->
						<!-- se selezionato Ricercatore o Direttore Dipartimento o Responsabile Area scientifica -> Aggiungere select con i Dipartimenti  -->
				    </div>
				   
				    
				    <p>{{ Form::submit('Crea utente') }}</p>
				<p>{{ Form::close() }}</p>
		
				<br>		
				Test Modifica Utente:
		
				<br>
				Test Rimozione Utente:
		
				<br>
				Test Visualizzazione Utente:
			</div>
		</section>
@stop
