<div class="onboarding">
	<div class="row">
		<div class="col col-md-12">
		    @include('_helpers.breadcrumbs')
		    <h1 class="no-top">Step 3: Bank Account Information</h1>
		    <p><small>(You can change these settings later.)</small></p>
		</div>
	</div>
	<form editable-form name="editableForm" onaftersave="saveShippingAddress($data)">
	    <div class="row">
	        <div class="col col-xl-3 col-lg-4 col-sm-6 col-sm-6">
	            <!-- {{ Form::open(array('url' => '/bankinfo')) }} -->
	
				<input type="hidden" name="onboard_process" value="true">
	
			    <div class="form-group">
			        {{ Form::label('phone', 'Driver License#') }}
			        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control','placeholder'=>'UT############')) }}
			    </div>
		
			    <div class="form-group">
			        {{ Form::label('phone', 'Social Security #') }}
			        {{ Form::text('phone', Input::old('ssn'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('phone', 'Phone') }}
			        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address_1', 'Address 1') }}
			        {{ Form::text('address_1', Input::old('address_1'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address_2', 'Address 2') }}
			        {{ Form::text('address_2', Input::old('address_2'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('city', 'City') }}
			        {{ Form::text('city', Input::old('city'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('state', 'State') }}
			        <br>
			        {{ Form::select('state',State::orderBy('full_name')->lists('full_name', 'abbr'), null, array('class' => 'form-control width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('zip', 'Zip') }}
			        {{ Form::text('zip', Input::old('zip'), array('class' => 'form-control')) }}
			    </div>
				
				<div class="form-group">
					<button type="button" class="btn btn-primary" ng-click="saveShippingAddress($data)">Next <i class="fa fa-angle-right"></i></button>
				</div>

	        </div><!-- col -->
	    </div><!-- row -->
	{{Form::close()}}
</div>

