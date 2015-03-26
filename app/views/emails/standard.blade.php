@extends('emails.layouts.basic')

@section('body')
	<img src="{{ $message->embed('img/email/purchase-header.jpg') }}" style="width:100%;">

	{{$user['first_name']}} {{$user['last_name']}},
	<p />
	<p />
	{{ $body}}
@stop

@section('footer')
	@parent
@stop
