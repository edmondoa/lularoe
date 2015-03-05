<div class="onboarding">
	<div class="row">
		<div class="col col-md-12">
		    @include('_helpers.breadcrumbs')
		    <h1 class="no-top">Step 3: Bank Account Information</h1>
		    <p><small>(You can change these settings later.)</small></p>
		</div>
	</div>
	<form editable-form name="editableForm" onaftersave="saveBankinfo($data)">
	    <div class="row">
	        <div class="col col-xl-3 col-lg-4 col-sm-6 col-sm-6">
	            <!-- {{ Form::open(array('url' => '/bankinfo')) }} -->
	
				<input type="hidden" name="onboard_process" value="true">
	
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
	                {{ Form::text('license_state', null, array('class' => 'form-control')) }}
	            </div>
	
	            <div class="form-group">
	                {{ Form::label('license_number', 'Driver License Number') }}
	                {{ Form::text('license_number', null, array('class' => 'form-control')) }}
	            </div>
	            
	            <div class="form-group">
					{{ Form::checkbox('agree', 1, true,['class'=>'pull-left']) }}
					<label for="agree" class="control-label">&nbsp; I agree to the <a href="/terms-conditions" target="_BLANK">terms and conditions<a/></label>
				</div>
				
				<div class="form-group">
					<button type="button" class="btn btn-primary" ng-click="saveBankinfo($data)">Next <i class="fa fa-angle-right"></i></button>
				</div>

	        </div><!-- col -->
	    </div><!-- row -->
	{{Form::close()}}
</div>

