@extends('layout.master')

@section('style')
	{{ HTML::style('css/timeline.css'); }}
@stop

@section('script')
	{{ HTML::script('js/timeline.js'); }}
@stop


@section('content')
	timeline
@stop
