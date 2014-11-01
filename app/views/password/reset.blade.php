@extends('layouts.centered')
@section('content')
	<div class="row">
		<div class="col col-md-12">
			<h1>Create New Password</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-md-3">
			{{ Form::open(array('action' => 'RemindersController@postReset', 'class' => 'full')) }}
				{{ Form::hidden('token',$token) }}
				
				<div class="form-group">
					{{ Form::label('email','Email') }}
					{{ Form::text('email', null, ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					{{ Form::label('password','Password') }}
					{{ Form::password('password', ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					{{ Form::label('password_confirmation','Enter it again') }}
					{{ Form::password('password_confirmation', ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					{{ Form::submit('Create New Password', ['class' => 'btn btn-primary']) }}
				</div>
				
			{{ Form::close() }}
		</div>
	</div>
@stop