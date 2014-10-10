@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<h2>Sign Up</h2>
		<p>Please enter your sponsor's ID to continue.</p>
	    {{ Form::open(array('action' => 'PreRegisterController@redirect', 'class' => 'full')) }}
	        {{ Form::label('sponsor_id', 'Sponsor ID') }}
	        {{ Form::text('sponsor_id') }}
		    {{ Form::submit('Sign Up', array('class' => 'btn btn-success')) }}
	    {{ Form::close() }}
	</div>
</div>
@stop