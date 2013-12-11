@extends('layout.dashboard')

@section('content.dashboard')
	<nav>
		<ul>
			<li>{{ HTML::link('dashboard/aggiungi-prodotto','Aggiungi prodotto',array('class'=>'btn')) }}</li>
			<li><a href="#" class="btn" id="del_prodotti">Elimina selezionati</a></li>
		</ul>
	</nav>
	<div>
		@foreach ($prodotti as $p) 
			<article class="prodotto trall @if(Session::has('newid') && $p->id == Session::get('newid')) {{ 'newid' }} @endif" data-id="{{ $p->id }}" @if(!$p->is_definitivo) {{ 'selectable' }} @endif>
				<header>
					<hgroup>
						<h1>{{ $p->titolo }}</h1>
						<h2><a href="#">{{ $p->areaScientifica['nome'] }}</a></h2>
						@if($p->tipo) <h3><a href="#">{{ $p->tipo }}</a></h3> @endif
					</hgroup>
					@if(!$p->is_definitivo)
						<span class="icon edit" title="Modifica" data-id="{{ $p->id }}"></span>
						<span class="icon remove" title="Elimina" data-id="{{ $p->id }}"></span>
					@else
						<span class="icon lock" title="Prodotto definitivo"></span>
					@endif
					
				 </header>
				 <section>
				 	{{ $p->descrizione }}
				</section>
				<footer>
					<span>Autori: <a href="#">Tu</a></span>
					<span><a href="#"><span class="icon allegato"></span>Allegato</a></span>
					<span>Pubblicato il {{ substr(date_format(date_create($p->data_pubblicazione),'d-m-Y H:i:s'),0,10); }}</span>
				</footer>
			</article>
		@endforeach
			{{ Form::open(array('url' => 'prodotti/remove')) }}
				{{ Form::hidden('prodotti_da_eliminare', null,array('id'=>'ips')) }}
			{{  Form::close() }}
	</div>
@stop
