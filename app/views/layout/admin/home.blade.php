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
				
				    {{ Form::text('data_giorno', Input::old('data_giorno'), array('placeholder' => 'giorno dd')) }}
				    {{ Form::text('data_mese', Input::old('data_mese'), array('placeholder' => 'mese mm')) }}
				    {{ Form::text('data_anno', Input::old('data_anno'), array('placeholder' => 'anno yyyy')) }}
				    </p>
				    
				    <p>{{ Form::label('Seleziona Grado') }}</p>
				    <p> <?php if (Session::has('gradeError')) echo Session::get('gradeError'); ?> </p>
				    <p>{{ Form::checkbox('amministratore', true) }} {{ Form::label('Amministratore') }} </p>
				    <p>{{ Form::checkbox('responsabilevqr', true) }} {{ Form::label('ResponsabileVQR') }}  </p>
				    <p>{{ Form::checkbox('ricercatore', true, true, array('id'=>'cb_ricercatore')) }} {{ Form::label('Ricercatore') }}  </p>
				   <div id="div_ratio">
						<p>{{ Form::radio('grado',1) }} {{ Form::label('Direttore di Dipartimento - solo se ricercatore') }} </p>
						<p>{{ Form::radio('grado',2) }} {{ Form::label('Responsabile area Scientifica - solo se ricercatore') }} </p>
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
