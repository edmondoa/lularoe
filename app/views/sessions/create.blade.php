@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-4">
		{{ Form::open(array('route' => 'sessions.store')) }}
	    <h1>Log In</h1>
		{{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email Address')) }}
		<br>
		{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
		<br>
		<button class='btn btn-success'>Log In</button>
		{{ Form::close() }}
		<br>
		<br>
		<p>Don't have an account? <a href='/join'>Sign up!</a></p>
	</div>
</div>
@stop