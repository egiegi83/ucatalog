@if (Session::has('message'))
	<div class="message error">
		{{ Session::get('message') }}
	</div>
@endif

{{ Form::open(array('url' => 'user/login')) }}
	<span>
		{{ Form::text('email', Input::old('email'), array('placeholder' => 'mail@example.com')) }}
		@if ($errors->first('email') != "")
			<label>{{ $errors->first('email') }}</label>
		@endif
	</span>
	<span>
		{{ Form::password('password') }}
		@if ($errors->first('password') != "")
			<label>{{ $errors->first('password') }}</label>
		@endif
	</span>
	{{ Form::submit('Accedi') }}
{{ Form::close() }}
