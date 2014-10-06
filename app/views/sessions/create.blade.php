@extends('layouts.default')
@section('content')
<div class="center">
	@include('_helpers.message')
	<div style="display:inline-block; text-align:left;">
		{{Form::open(array('route' => 'sessions.store'))}}
			{{ Form::label('username','Username') }}
			{{ Form::text('username') }}
			{{ Form::label('password','Password') }}
			{{ Form::password('password') }}
			<br>
			{{Form::submit('Log In',array('class'=>'center-block'))}}
		{{Form::close()}}
	</div>
	<p>Don't have an account? <a href='/users/create'>Sign up!</a></p>
</div>
@stop
