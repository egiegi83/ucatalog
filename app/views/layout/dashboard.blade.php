@extends('layout.master')

@section('style')
	{{ HTML::style('css/dashboard.css'); }}
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
				dettagli profilo
			@show
		</div>
	</section>
	
@stop
