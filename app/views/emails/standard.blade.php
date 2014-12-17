@extends('emails.layouts.basic')

@section('body')
	{{$user['first_name']}} {{$user['last_name']}},
	<p />
	<p />
	{{ $body}}
@stop

@section('footer')
	@parent
@stop