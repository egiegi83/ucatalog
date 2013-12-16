@extends('layout.dashboard')

@section('substyle')
	{{ HTML::style('css/article.css'); }}
@stop

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
						<h2><a href="#">{{ $p->areaScientifica()->get()->first()->nome }}</a></h2>
						<h3><a href="#">{{ $p->tipo }}</a></h3>
					</hgroup>
					@if(!$p->is_definitivo)
						<a href="{{ URL::to('dashboard/modifica') . '/' . $p->id }}" class="icon edit" title="Modifica"></a>
						<span class="icon remove" title="Elimina" data-id="{{ $p->id }}"></span>
					@else
						<span class="icon lock" title="Prodotto definitivo"></span>
					@endif
					
				 </header>
				 <section>
				 	{{ $p->descrizione }}
				</section>
				<footer>
					<?php $co = $p->getCoautori() ?>
					@if(count($co)>0)
					  	<span class="autori">
						  	<label>Autori</label>
						  	@foreach($co as $c)
						 		 <?php if(isset($f)) echo ','; ?>
						 		 @if($c['type']=='1')
						 		 	<a href="{{ URL::to('/$rpp->ricercatore_id'); }}">
						 		 		{{ $c['coautore'] }}
					 		 		</a>
								@else
									{{ $c['coautore'] }}
								@endif
								<?php $f=true; ?>
							@endforeach
				  		</span>
				  	@endif
					<span>
						@if($sps=$p->allegatiProdotto)
							<label>Allegati</label>
							<ul class="allegati">
							@foreach($sps as $sp)
								<li><a href="{{ $sp->getURL() }}" target="_blank"><span class="icon allegato"></span>{{ $sp->getNomeFile() }}</a></span></li>
							@endforeach
							</ul>
						@endif
					</span>
					<span>Pubblicato il {{ substr(date_format(date_create($p->data_pubblicazione),'d-m-Y H:i:s'),0,10); }}</span>
				</footer>
			</article>
		@endforeach
			{{ Form::open(array('url' => 'prodotti/remove')) }}
				{{ Form::hidden('prodotti_da_eliminare', null,array('id'=>'ips')) }}
			{{  Form::close() }}
	</div>
@stop
