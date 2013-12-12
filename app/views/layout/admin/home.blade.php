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
						{{ Form::select('dipartimento', $dipartimenti) }}
				
				<!--	la vecchia select è sostituita dalla select dinamica
					
						{{ Form::select('dipartimento', array(
						'' => 'Seleziona dipartimento', 
						'1' => 'Dipartimento di Scienze del Patrimonio Culturali', 
						'2' => 'Dipartimento di Chimica e Biologia',
						'3' => 'Dipartimento di Scienze Giuridiche ',
						'4' => 'Dipartimento di Fisica "E.R. Caianiello"',
						'5' => 'Dipartimento di Informatica',
						'6' => 'Dipartimento di Ingegneria Civile',
						'7' => "Dipartimento di Ingegneria dell'informazione, Ingegneria elettrica e Matematica Applicata",
						'8' => 'Dipartimento di Ingegneria Industriale',
						'9' => 'Dipartimento di Matematica',
						'10' => 'Dipartimento di Scienze Economiche e Statistiche',
						'11' => 'Dipartimento di Farmacia',
						'12' => 'Dipartimento di Medicina e Chirurgia',
						'13' => 'Dipartimento di Scienze Umane, Filosofiche e della Formazione',
						'14' => 'Dipartimento di Scienze Politiche, Sociali e della Comunicazione',
					)) }}
				-->
					@if($errors->first('dipartimento'))
						<label>{{ $errors->first('dipartimento') }}</label>
					@endif
					
							<p>{{ Form::label('Seleziona Area di Ricerca') }}</p>
							{{ Form::select('area', $aree_di_ricerca) }}
					
				<!--	la vecchia select è sostituita dalla select dinamica
							{{ Form::select('area', array(
							'' => 'Seleziona area di ricerca', 
							'1' => 'Scienze matematiche e informatiche', 
							'2' => 'Scienze fisiche',
							'3' => 'Scienze chimiche',
							'4' => 'Scienze della terra',
							'5' => 'Scienze biologiche',
							'6' => 'Scienze mediche',
							'7' => 'Scienze agrarie e veterinarie',
							'8' => 'Ingegneria civile ed architetturale',
							'9' => "Ingegneria industriale e dell'informazione",
							'10' => "Scienze dell'antichità, filologo-letterarie e storico-artistiche",
							'11' => 'Scienze storiche, filosofiche, psicologiche, pedagogiche',
							'12' => 'Scienze giuridiche',
							'13' => 'Scienze economiche e statistiche',
							'14' => 'Scienze politiche e sociali',
						)) }}
				-->
						@if($errors->first('area'))
							<label>{{ $errors->first('area') }}</label>
						@endif

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
