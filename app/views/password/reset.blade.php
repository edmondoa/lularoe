@extends('layouts.centered')
@section('content')
	{{ Form::open(array('action' => 'RemindersController@postReset', 'class' => 'full')) }}
		{{ Form::hidden('token',$token)}}
		{{ Form::label('email','Email')}}
		{{ Form::text('email')}}
		{{ Form::label('password','Password')}}
		{{ Form::password('password')}}
		{{ Form::label('password_confirmation','Enter it again')}}
		{{ Form::password('password_confirmation')}}
		{{ Form::submit('Reset my Password')}}
	{{ Form::close()}}

@stop