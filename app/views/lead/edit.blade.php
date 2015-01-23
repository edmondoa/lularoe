@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1>Edit lead</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::model($lead, array('route' => array('leads.update', $lead->id), 'method' => 'PUT')) }}
		
		    
		    <div class="form-group">
		        {{ Form::label('first_name', 'First Name') }}
		        {{ Form::text('first_name', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('last_name', 'Last Name') }}
		        {{ Form::text('last_name', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('email', 'Email') }}
		        {{ Form::text('email', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('gender', 'Gender') }}
		        {{ Form::text('gender', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('dob', 'Dob') }}
		        {{ Form::text('dob', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('phone', 'Phone') }}
		        {{ Form::text('phone', null, array('class' => 'form-control')) }}
		    </div>
		    
		    @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
			    <div class="form-group">
				    <div class="form-group">
				        {{ Form::label('sponsor_id', 'Assign to ISM') }}
				        {{ Form::text('sponsor_id', null, array('class' => 'form-control', 'placeholder' => 'ISM ID')) }}
				    </div>
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('opportunity_id', 'Opportunity ID') }}
			        {{ Form::text('opportunity_id', null, array('class' => 'form-control')) }}
			    </div>
			@endif
		    
		    <!-- <div class="form-group">
		        {{ Form::label('disabled', 'Disabled') }}
		        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
		    </div> -->
		    
		
		    {{ Form::submit('Update Lead', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

