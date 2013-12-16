@extends('layout.master')
@section('style')
	{{ HTML::style('css/panel.css'); }}
@stop

@section('script')
	{{ HTML::script('js/admin.js'); }}
@stop

@section('content')
	<nav>
		<ul>
			<li class="trall">{{ HTML::link('admin/lista-utenti','Utenti') }}</li>	
			<li class="trall">{{ HTML::link('admin/messaggi','Messaggi') }}</li>
	</nav>
	<section class="trall">
		<div class="trop">
			@section('content.admin')
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
						{{ Form::selectRange('data_anno', 1940, date('Y')-23 ) }}
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
							<p>{{ Form::label('Seleziona Ruolo') }}</p>
							{{ Form::select('ruolo', array(
							'' => 'Seleziona ruolo', 
							'Professore ordinario' => 'Professore ordinario', 
							'Professore associato' => 'Professore associato',
							'Ricercatore' => 'Ricercatore',
							'Borsista post-dottorato' => 'Borsista post-dottorato',
							'Assegnista di ricerca' => 'Assegnista di ricerca',
							'Dottorando' => 'Dottorando',
						)) }}
						@if($errors->first('ruolo'))
							<label>{{ $errors->first('ruolo') }}</label>
						@endif
							<p>{{ Form::label('Seleziona Dipartimento') }}</p>
							{{ Form::select('dipartimento', BaseController::getDipartimenti()) }}
				
						@if($errors->first('dipartimento'))
							<label>{{ $errors->first('dipartimento') }}</label>
						@endif
					
								<p>{{ Form::label('Seleziona Area di Ricerca') }}</p>
								{{ Form::select('area',  BaseController::getAreeDiRicerca()) }}
					
							@if($errors->first('area'))
								<label>{{ $errors->first('area') }}</label>
							@endif

						</div>
					   
						
						<p>{{ Form::submit('Crea utente') }}</p>
						<p>{{ Form::close() }}</p>
					
					@show
			</div>
		</section>
@stop
