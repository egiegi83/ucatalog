@extends('layout.master')
@section('login')
    {{ Form::open(array('url' => 'login')) }} 
    {{ Form::text('email', Input::old('email'), array('placeholder' => 'mail@example.com')) }}
    {{ $errors->first('email') }}
    {{ Form::password('password') }}
    {{ $errors->first('password') }}
    {{ Form::submit('login') }}
    {{ Form::close() }}
@stop
