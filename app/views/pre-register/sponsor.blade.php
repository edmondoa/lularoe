@extends('layouts.centered')
@section('content')
<div class="row">
	<div class="col col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<h2>Sign Up</h2>
		<div class="alert alert-warning">Please enter your sponsor's ID to continue.</div>
	    {{ Form::open(array('action' => 'PreRegisterController@redirect', 'class' => 'full')) }}
	        {{ Form::label('sponsor_id', 'Sponsor ID') }}
	        {{ Form::text('sponsor_id', null, array('class' => 'form-control')) }}
	        <br>
		    {{ Form::submit('Sign Up', array('class' => 'btn btn-success')) }}
	    {{ Form::close() }}
	</div>
</div>
@stop