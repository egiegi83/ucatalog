@extends('layout.master')

@section('style')
	{{ HTML::style('css/panel.css'); }}
	@section('substyle')
	@show
@stop

@section('script')
	{{ HTML::script('js/dashboard.js'); }}
@stop

@section('content')
	<nav>
		<ul>
			<li class="trall">{{ HTML::link('dashboard','Dashboard') }}</li>
			<li class="trall">{{ HTML::link('dashboard/prodotti','Prodotti') }}</li>
			@if (Auth::getUser()->getTipo() == 2 || Auth::getUser()->getTipo() == 3)
			<li class="trall">{{ HTML::link('valida/lista-prodotti','Validazione') }}</li>
			@endif
			<li class="trall">{{ HTML::link('#','Messaggi') }}</li>	
			<li class="trall">{{ HTML::link('timeline/' . Auth::getUser()->nome .'-' . Auth::getUser()->cognome . '-' . Auth::getUser()->ricercatore->id ,'Timeline') }}</li>	
	</nav>
	<section class="trall">
		<div class="trop">
			@section('content.dashboard')
				<p>Nome: {{ Auth::getUser()->nome; }}</p>
				<p>Cognome: {{ Auth::getUser()->cognome; }}</p>
				<p>Prodotti bozza: {{ Auth::getUser()->ricercatore->prodottiBozza()->count(); }}</p>
				<p>Prodotti definitivi: {{ Auth::getUser()->ricercatore->prodottiDefinitivi()->count(); }}</p>
				<p>
					Prodotti in cui sei taggato: {{ 
						$prodotti=Prodotto::WhereIn('id',function($query){
							$query->select('prodotto_id')
							->from('ricercatore_partecipa_prodotto')
							->whereRaw('ricercatore_partecipa_prodotto.ricercatore_id = ' . Auth::getUser()->ricercatore->id);
						})->count();
					 }}
				 </p>
			@show
		</div>
	</section>
@stop
