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
			<article class="prodotto trall" data-id="{{ $p->id }}">
				<header>
					<hgroup>
						<h1>{{ $p->titolo }}</h1>
						<h2><a href="#">{{ $p->tipo }}</a></h2>
					</hgroup>
					<span class="icon edit" title="Modifica" data-id="{{ $p->id }}"></span>
					<span class="icon remove" title="Elimina" data-id="{{ $p->id }}"></span>
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
