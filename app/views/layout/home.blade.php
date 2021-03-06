@extends('layout.master')

@section('style')
	{{ HTML::style('css/home.css'); }}
	{{ HTML::style('css/article.css'); }}
@stop

@section('script')
	{{ HTML::script('js/home.js'); }}
@stop


@section('content')
	<section>
		<div id="pagesearch" class="page trop">
			<div id="search" class="trall" >
				{{ Form::open(array('url' => 'advanced-search')) }}
					{{ Form::text('Cerca', null, array('placeholder'=>'Ricerca prodotto per titolo, autore, parola chiave...','id' => 'tb_search','autocomplete'=>'off' ,'x-webkit-speech')) }}
					{{ Form::submit('', array('id' => 'btn_search' )) }}
					<span class="icon params tT" data-target="#filtri"></span>
					<div id="autocomplete">
				
					</div>
					<div id="filtri">
						<span>
							{{ Form::select('area_di_ricerca',  BaseController::getAreeDiRicerca()) }}
						</span>
						<span>
							{{ Form::select('dipartimento',  BaseController::getDipartimenti()) }}
						</span>
						<span>
							{{ Form::text('autori', null, array('placeholder'=>'Autori separati da ,','size'=>'16'))}}
						</span>
						<span>
							<label>Anno</label>
							{{ Form::text('anno_da', null, array('placeholder'=>'da', 'size' => '2'))}}
							{{ Form::text('anno_a', null, array('placeholder'=> 'a','size'=>'2'))}}
						</span>
					</div>
				{{ Form::close() }}
			</div>
		</div>
		<div id="pagelatest" class="page trop">
			<div class="pagecontent">
				<h2 id="h2r">Ultimi caricamenti</h2>
				<div class="prodotti" id="prodotti">
					@foreach ($prodotti as $p) 
					<article class="prodotto">
						<header>
							<hgroup>
								<h1>{{ $p->titolo }}</h1>
								<h2><a href="#">{{ $p->areaScientifica()->get()->first()->nome }}</a></h2>
								<h3><a href="#">{{ Prodotto::typeToString($p->tipo) }}</a></h3>
							</hgroup>
						</header>
						 <section>
						 	{{ $p->descrizione }}
						</section>
						<footer>
							<?php $co = $p->getCoautori(); $f=false; ?>
							@if(count($co)>0)
							  	<span class="autori">
								  	<label>Autori</label>
								  	@foreach($co as $c)
								 		 <?php if($f) echo ','; ?>
								 		 @if($c['type']=='1')
								 		 	<a href="{{ URL::to('timeline/' . str_replace(' ','-',$c['coautore']) . '-'. $c['id']) }}">
								 		 		{{ $c['coautore'] }}
							 		 		</a>
										@else
											{{ $c['coautore'] }}
											<?php $f=true; ?>
										@endif
									@endforeach
						  		</span>
						  	@endif
					
							@if($sps=$p->allegatiProdotto)
								@if($sps->count()>0)
									<span>
										<label>Allegati</label>
										<ul class="allegati">
										@foreach($sps as $sp)
											<li><a href="{{ URL::to('prodotti/download/'.$sp->getId()) }}" target="_blank"><span class="icon allegato"></span>{{ $sp->getNomeFile() }}</a></span></li>
										@endforeach
										</ul>
									</span>
								@endif
							@endif
							<?php $u = Ricercatore::find($p->ricercatore_id)->utente ?>
							<span>
								<label>Pubblicato</label> 
								da <a href="{{ URL::to('timeline/' . $u->getNome() . '-' . $u->getCognome() . '-'. $p->ricercatore_id) }}">
									{{  $u->getNome() . ' ' . $u->getCognome() }}
								</a>
								@if(($dp = substr(date_format(date_create($p->data_pubblicazione),'d-m-Y H:i:s'),0,10)) != '01-01-2000')
									il {{ $dp }}
								@endif
							</span>
						</footer>
					</article>
				@endforeach
				</div>
			</div>
		</div>
		
		<div id="arrow">
			<span class="left trall" style="display:none"><span class="trop"></span></span>
			<span class="right trall"><span class="trop"></span></span>
		</div>
	</section>
@stop
