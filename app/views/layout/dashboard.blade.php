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
			<li class="trall">{{ HTML::link('dashboard/messaggi','Messaggi') }}</li>	
	</nav>
	<section class="trall">
		<div class="trop">
			@section('content.dashboard')
				<p>Nome: {{ Auth::getUser()->nome; }}</p>
				<p>Cognome: {{ Auth::getUser()->cognome; }}</p>
				<p>Prodotti bozza: {{ Auth::getUser()->ricercatore->prodottiBozza()->count(); }}</p>
				<p>Prodotti definitivi: {{ Auth::getUser()->ricercatore->prodottiDefinitivi()->count(); }}</p>
			@show
		</div>
	</section>
@stop
