@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Bank Account Information</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-6 col-md-6 col-sm-6">
		    {{ Form::open(array('url' => 'bankinfo/store')) }}
		
		    <div class="form-group">
		        {{ Form::label('bank_name', 'Bank Name') }}
		        {{ Form::text('bank_name', null, array('class' => 'form-control','placeholder'=>'e.g. Chase Bank')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('bank_routing', 'Routing #') }}
		        {{ Form::text('bank_routing', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('bank_account', 'Account #') }}
		        {{ Form::text('bank_account', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('license_state', 'Driver License State') }}
				{{ Form::select('license_state', State::orderBy('full_name')->lists('full_name', 'abbr'), null, array('class' => 'form-control width-auto')) }}

		    </div>

		    <div class="form-group">
		        {{ Form::label('license_number', 'Driver License Number') }}
		        {{ Form::text('license_number', null, array('class' => 'form-control')) }}
		    </div>
		    
		    {{ Form::submit('Update Bank Info', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
		<div class="col col-lg-6 col-md-6 col-sm-6">
			<img src="/img/media/check.png">
		<div>
	</div>
</div>
@stop
