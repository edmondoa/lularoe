@extends('layouts.gray')
@section('content')
<div class="show">
	<div class="row">
		<div class="col col-md-9">
			<div class="col col-md-12">
				<h1>{{ $opportunity->title }}</h1>
				{{ $opportunity->body }}
				<br>
				<br>
				@if ($opportunity->include_form == 1 && $opportunity->deadline != '')
					<h3>Application Deadline</h3>
					{{ date('l', $opportunity->date) }}, {{ date('F', $opportunity->date) }} {{ date('j', $opportunity->date) }}, {{ $opportunity->formatted_deadline_time }}
				@endif
			</div>
	    </div>
	    <div class="col col-md-3">
	    	<div class="col col-md-12">
	    		<h1>@if (isset($already_submitted)){{ $already_submitted }}@endif</h1>
		    	@if ($opportunity->include_form == 1 && (!Session::get('already_submitted')))
			    	<div class="panel panel-primary">
			    		<div class="panel-heading">
			    			<h2 class="panel-title">Sign Up</h2>
			    		</div>
			    		<div class="panel-body">
						    {{ Form::open(array('url' => 'leads')) }}
								
							    <div class="form-group">
							        {{ Form::label('first_name', 'First Name') }}
							        {{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control')) }}
							    </div>
							    
							    <div class="form-group">
							        {{ Form::label('last_name', 'Last Name') }}
							        {{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control')) }}
							    </div>
							    
							    <div class="form-group">
							        {{ Form::label('email', 'Email') }}
							        {{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
							    </div>
							    
							    <div class="form-group">
							        {{ Form::label('phone', 'Phone') }}
							        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
							    </div>
							    
							    <div class="form-group">
							        {{ Form::label('dob', 'Date of Birth') }}
							        {{ Form::text('dob', Input::old('dob'), array('class' => 'form-control dateonlypicker')) }}
							    </div>
							    
							    <div class="form-group">
						    		{{ Form::label('gender', 'Gender') }}<br>
						    		{{ Form::select('gender', array(
								    	'M' => 'Male',
								    	'F' => 'Female',
								    ), null, array('class' => 'selectpicker form-control')) }}
							    </div>
							    
							    {{ Form::hidden('sponsor_id', $sponsor->id) }}
							    {{ Form::hidden('opportunity_id', $opportunity->id) }}
						    	{{ Form::hidden('from_opportunity', 1) }}
						    	
						    {{ Form::submit('Sign Up', array('class' => 'btn btn-primary')) }}
			    		</div>
			    	</div>
		    	@endif
		    </div>
	    </div>
	</div>
</div>
@stop
