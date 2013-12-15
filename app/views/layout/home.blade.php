@extends('layout.master')

@section('style')
	{{ HTML::style('css/home.css'); }}
@stop

@section('script')
	{{ HTML::script('js/home.js'); }}
@stop


@section('content')
	<section>
		<div id="pagesearch" class="page">
			<div id="search">
				{{ Form::open(array('url' => 'user/logout')) }}
					{{ Form::text('Cerca', null, array('placeholder'=>'Ricerca prodotto per titolo, autore, parola chiave...','id' => 'tb_search','autocomplete'=>'off' ,'x-webkit-speech')) }}
					{{ Form::submit('', null, array('id' => 'btn_search' )) }}
					<span class="icon params tT" data-target="#filtri"></span>
					<div id="autocomplete">
				
					</div>
					<div id="filtri">
						<span>
							{{ Form::select('tipologia', array('0' => 'Tutte le tipologie', '1' => 'Libro','2' => 'Rivista','3' => 'Articolo')) }}
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
		<div id="pagelatest" class="page">
			
		</div>
		
		<div id="arrow">
			<span class="left trall" style="display:none"><span class="trop"></span></span>
			<span class="right trall"><span class="trop"></span></span>
		</div>
	</section>
@stop
