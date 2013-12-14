@extends('layout.dashboard')

@section('substyle')
	{{ HTML::style('css/dashboard.css'); }}
@stop

@section('content.dashboard')
	<h1>Aggiungi prodotto</h1>
	<div id="addProdotto">
		{{ Form::open(array('url' => 'prodotti/aggiungi', 'files'=> true)) }}
				<!-- Campi comuni a tutti i tipi di prodotto -->	
				<span>
					{{ Form::text('titolo', null, array('placeholder'=>'Titolo','autocomplete'=>'off')) }}
					@if($errors->first('titolo'))
						<label>{{ $errors->first('titolo') }}</label>
					@endif
				</span>
								
				<span>
					{{ Form::select('area_di_ricerca',  BaseController::getAreeDiRicerca()) }}
					
				<!--	
					{{ Form::select('area_di_ricerca', array(
						'' => 'Area di ricerca', 
						'1' => 'Scienze matematiche e informatiche', 
						'2' => 'Scienze fisiche',
						'3' => 'Scienze chimiche',
						'4' => 'Scienze della terra',
						'5' => 'Scienze biologiche',
						'6' => 'Scienze mediche',
						'7' => 'Scienze agrarie e veterinarie',
						'8' => 'Ingegneria civile ed architetturale',
						'9' => "Ingegneria industriale e dell'informazione",
						'10' => "Scienze dell'antichità, filologo-letterarie e storico-artistiche",
						'11' => 'Scienze storiche, filosofiche, psicologiche, pedagogiche',
						'12' => 'Scienze giuridiche',
						'13' => 'Scienze economiche e statistiche',
						'14' => 'Scienze politiche e sociali'
					)) }}
				-->
					@if($errors->first('area_di_ricerca'))
						<label>{{ $errors->first('area_di_ricerca') }}</label>
					@endif
				</span>	
				<p>
					<!-- Questa è una text area, può essere anche piuttosto lunga-->
					<span>
						{{ Form::textarea('descrizione', null, array('placeholder'=>'Descrizione','autocomplete'=>'off' )) }}
						@if($errors->first('descrizione'))
							<label>{{ $errors->first('descrizione') }}</label>
						@endif
					</span>				
				</p>
				<!-- L'aggiunta degli autori dovrebbe essere come il tag su Facebook, vedendo quelli 
					presenti nella tabella ricercatori -->

					
				<div class="autori">
					<label>Autori:</label>
					<div id="ctbta">
						<div id="tbc">
							<span id="selected_autori"></span>
							<span id="tb_autori" placeholder="Autore" contenteditable="true"></span>
						</div>
						<div id="tag_autori" ></div>
						{{ Form::hidden('autori', null, array('autocomplete'=>'off','id' => 'hid_autori' )) }}
					</div>
				</div>
				
				<p class="date">
					<label>Data pubblicazione:</label>
					{{ Form::selectRange('data_p_day',1,31) }} /
					{{ Form::selectMonth('data_p_month') }} /
					{{ Form::selectRange('data_p_year', 2000, date('Y') ) }}
				<!-- modificato 'anno' in 'data_pubblicazione' -->
				</p>
				
				<span>
				<!-- A seconda della tipologia che si sceglie sono visualizzati i campi -->	
					{{ 
						Form::select('tipo', array(
							'' => 'Seleziona la tipologia', 
							'articoli_su_rivista' => 'Articolo su rivista', 
							'libri' => 'Libro/Capitolo di Libro',
							'convegni' => 'Convegno/Atto di convegno',
							'traduzioni' => 'Commenti specifico/Edizione critica/Traduzione',
							'brevetti' => 'Brevetto',
							'altri_prodotti' => 'Altro'
						)) 
					}}
					@if($errors->first('tipo'))
						<label>{{ $errors->first('tipo') }}</label>
					@endif
				</span>
				<div class="hiddeni trop">
					<!-- Rivista -->
					<span data-type="articoli_su_rivista" >
						{{ Form::text('titolo_rivista', null, array('placeholder'=>'Titolo rivista','autocomplete'=>'off' )) }}
						@if($errors->first('titolo_rivista'))
							<label>{{ $errors->first('titolo_rivista') }}</label>
						@endif
					</span>
				
					<span data-type="articoli_su_rivista" >
						{{ Form::text('issn', null, array('placeholder'=>'ISSN','autocomplete'=>'off' )) }}
						@if($errors->first('issn'))
							<label>{{ $errors->first('issn') }}</label>
						@endif
					</span>
				
					<span data-type="articoli_su_rivista libri convegni" >
						{{ Form::text('pagina_iniziale', null, array('placeholder'=>'Pagina iniziale','autocomplete'=>'off' )) }}		
						@if($errors->first('pagina_iniziale'))
							<label>{{ $errors->first('pagina_iniziale') }}</label>
						@endif
					</span>
				
					<span data-type="articoli_su_rivista libri convegni" >
						{{ Form::text('pagina_finale', null, array('placeholder'=>'Pagina finale','autocomplete'=>'off' )) }}		
						@if($errors->first('pagina_finale'))
							<label>{{ $errors->first('pagina_finale') }}</label>
						@endif
					</span>
				
					<span data-type="articoli_su_rivista" >
						{{ Form::text('numero_rivista', null, array('placeholder'=>'Numero rivista','autocomplete'=>'off' )) }}		
						@if($errors->first('numero_rivista'))
							<label>{{ $errors->first('numero_rivista') }}</label>
						@endif
					</span>

					<!-- Libro -->
					<span data-type="libri convegni articoli_su_rivista" >
						{{ Form::text('doi', null, array('placeholder'=>'DOI','autocomplete'=>'off' )) }}
						@if($errors->first('doi'))
							<label>{{ $errors->first('doi') }}</label>
						@endif	
					</span>
					<span data-type="libri" >
						{{ Form::text('titolo_libro', null, array('placeholder'=>'Titolo Libro/Capitolo di Libro','autocomplete'=>'off' )) }}
						@if($errors->first('titolo_libro'))
							<label>{{ $errors->first('titolo_libro') }}</label>
						@endif
					</span>
				
					<span data-type="libri convegni" >
						{{ Form::text('isbn', null, array('placeholder'=>'ISBN','autocomplete'=>'off' )) }}
						@if($errors->first('isbn'))
							<label>{{ $errors->first('isbn') }}</label>
						@endif
					</span>	
					<span data-type="libri convegni" >
						{{ Form::text('editore', null, array('placeholder'=>'Editore','autocomplete'=>'off' )) }}
						@if($errors->first('editore'))
							<label>{{ $errors->first('editore') }}</label>
						@endif
					</span>
				
					<!-- Atto di convegno -->
					<span data-type="convegni" >
						{{ Form::text('nome_convegno', null, array('placeholder'=>'Nome convegno','autocomplete'=>'off' )) }}
						@if($errors->first('nome_convegno'))
							<label>{{ $errors->first('nome_convegno') }}</label>
						@endif
					</span>
					<span data-type="convegni" >
						
					<!--
						{{ Form::text('data_convegno', null, array('placeholder'=>'Data convegno','autocomplete'=>'off' )) }}
						@if($errors->first('data_convegno'))
							<label>{{ $errors->first('data_convegno') }}</label>
						@endif
					-->
						{{ Form::selectRange('data_con_day',1,31) }} 
						{{ Form::selectMonth('data_con_month') }} 
						{{ Form::selectRange('data_con_year', 2000, date('Y') ) }}
						@if($errors->first('data_convegno'))
							<label>{{ $errors->first('data_convegno') }}</label>
						@endif
					
					</span>
					<span data-type="convegni" >
						{{ Form::text('luogo_convegno', null, array('placeholder'=>'Luogo convegno','autocomplete'=>'off' )) }}
						@if($errors->first('luogo_convegno'))
							<label>{{ $errors->first('luogo_convegno') }}</label>
						@endif
					</span>
				
					<!-- Commento specifico/Edizione critica/Traduzione -->
					<span data-type="traduzioni" >
						{{ Form::text('lingua', null, array('placeholder'=>'lingua','autocomplete'=>'off' )) }}
						@if($errors->first('lingua'))
							<label>{{ $errors->first('lingua') }}</label>
						@endif
					</span>
		
				
					<!-- Altro -->
					<span data-type="altri_prodotti" >
						{{ Form::text('altra_tipologia', null, array('placeholder'=>'Altra tipologia	','autocomplete'=>'off' )) }}
						@if($errors->first('altra_tipologia'))
							<label>{{ $errors->first('altra_tipologia') }}</label>
						@endif
					</span>
				</div>
				
				<p>
					<span id="allegati">
						{{ Form::file('allegati[]', null) }} 
						@if($errors->first('allegati'))
							<label>{{ $errors->first('allegati') }}</label>
						@endif
					</span>
					<span class="addFile">+<span class="icon allegato" id="add_file" title="Aggiungi altro file"></span></span>
				</p>
				
				<!-- Altro (tutti i campi) -->
				<p class="btnc">
					{{ Form::submit('Salva come definitivo', array('id' => 'btn_search','name' =>'save_def')) }}
					{{ Form::submit('Salva come bozza', array('id' => 'btn_search','name' =>'save_boz')) }}
				</p>
			{{ Form::close() }}
	</div>
@stop
