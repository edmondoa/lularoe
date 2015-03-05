@extends('emails.layouts.default')
@section('body')
	<h1>LulaRoe Email Confirmation</h1>
	<p>Thank you for signing up with LuLaRoe.</p>
	<p><a href="{{$verification_link}}">Click here to verify your email address and continue the sign up process.</a></p>
@stop
@section('footer')
	@parent
@stop