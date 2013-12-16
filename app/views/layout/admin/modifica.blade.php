@extends('layout.admin.home')

@section('content.admin')

<?php if (Session::has('message')) {
$message = Session::get('message');
echo $message;
}?>

<p>	{{Form::model($user, array('url' => array('admin/update',$user->utente_id )))}}</p> 
     <p>{{ Form::label('email') }}</p>
    {{ $errors->first('email') }}
    <p>{{ Form::text('email',$user->getreminderemail(),array('disabled'=>'disabled'))}}</p>
    
    <p>{{ Form::label('password') }}</p>
    <p>{{ $errors->first('password') }}</p>
    <p>{{ $errors->first('password_confirmation') }}</p>
    <p>{{ Form::password('password') }}</p>
    
    <p>{{ Form::label('Retype Password') }}</p>
    <p>{{ Form::password('password_confirmation') }}</p>
    
    <p>{{ Form::label('Nome') }}</p>
    {{ $errors->first('nome') }}
    <p>{{ Form::text('nome') }}</p>
    
    <p>{{ Form::label('Cognome') }}</p>
    {{ $errors->first('cognome') }}
    <p>{{ Form::text('cognome') }}</p>
    
    <p>{{ Form::label('Data Di Nascita') }}</p>
    {{ $errors->first('data') }}
    <p>
	<?php list($year,$month,$day)=explode("-", $user->data_di_nascita); ?>
	{{ Form::selectRange('data_giorno',1,31, substr($day,0,2)) }} /
	{{ Form::selectMonth('data_mese', $month) }} /
	{{ Form::selectRange('data_anno', 1940, date('Y')-23, $year) }}
    </p>
	@if($user->tipo!='4')
	<p>{{ Form::label('Seleziona tipo') }}</p>
		{{ Form::select('tipo', array(
		'' => 'Seleziona tipo', 
		'1' => 'Ricercatore', 
		'2' => 'Direttore di Dipartimento',
		'3' => 'Responsabile Area Scientifica',
	)) }}
	@if($errors->first('tipo'))
		<label>{{ $errors->first('tipo') }}</label>
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
		{{ Form::select('dipartimento_id', $dipartimenti) }}
		
		@if($errors->first('dipartimento_id'))
		<label>{{ $errors->first('dipartimento_id') }}</label>
	@endif
	
			<p>{{ Form::label('Seleziona Area di Ricerca') }}</p>
			{{ Form::select('area_scientifica_id', $aree_di_ricerca) }}
				
			@if($errors->first('area_scientifica_id'))
			<label>{{ $errors->first('area_scientifica_id') }}</label>
		@endif
	@endif
    </div>
   
    
    <p>{{ Form::submit('Modifica utente') }}</p>
<p>{{ Form::close() }}</p>
@stop
