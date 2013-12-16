<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>uCatalog</title>
		
		{{ HTML::style('css/uc.css') }}
		{{ HTML::style('css/master.css') }}
		
		@section('style')		
		@show
		
		{{ HTML::script('js/ucatalog.js') }}
		{{ HTML::script('js/script.js') }}
		
		@section('script')		
		@show
    </head>
	
	<body>
		<header>
			<div class="lc">
				<a href="{{ URL::to('/') }}" class="logo">{{ HTML::image('img/ucatalog-logo.png','uCatalog - logo') }}</a>
				 
				<div class="hui">
					@if (!Auth::check())
						@include('layout.master.login')
					@else
						<a href="
						@if (Auth::getUser()->getTipo() == 0)
							{{ URL::to('/admin') }}
						@else
							{{ URL::to('/dashboard') }}
						@endif
						">{{ Auth::getUser()->nome . " " . Auth::getUser()->cognome . " (tipo ". Auth::getUser()->tipo . " )" }}</a>
						
						<span class="icon mail"></span>
						
						{{ Form::open(array('url' => 'user/logout')) }}
							{{ Form::submit('Esci') }}
						{{ Form::close() }}
				
					@endif
				</div>
			</div>
		</header>
		
		<section>
			@section('content')

			@show
		</section>
		
		<footer>
			<nav class="lc">
				<ul>
					<li>Informazioni</li>
					<li>il Progetto</li>
					<li>il Team de <i>il Gruppo due</i></li>
				</ul>
			</nav>	
		</footer>
	</body>
</html>
