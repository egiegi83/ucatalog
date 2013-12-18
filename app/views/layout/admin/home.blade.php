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
				 
			@show
			</div>
		</section>
@stop
