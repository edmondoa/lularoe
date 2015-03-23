<div class="onboarding">
	<div class="row">
		<div class="col col-md-12">
		    @include('_helpers.breadcrumbs')
		    <h1 class="no-top">Step 5: Address Information</h1>
		    <p><small>(You can change these settings later.)</small></p>
		</div>
	</div>
	<form editable-form name="editableForm" onaftersave="saveShippingAddress($data)">
	    <div class="row">
	        <div class="col col-xl-3 col-lg-4 col-sm-6 col-sm-6">
	
				<input type="hidden" name="onboard_process" value="true">
	
			    <div id="address-billing">
			    	<h3>Billing Address</h3>
			    	{{ Form::hidden('addresses[1][label]', 'Billing') }}
				    <div class="form-group">
				        {{ Form::label('addresses[1][address_1]', 'Address 1') }}
				        {{ Form::text('addresses[1][address_1]', null, array('class' => 'form-control', 'ng-model' => 'billing.address_1')) }}
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('addresses[1][address_2]', 'Address 2') }}
				        {{ Form::text('addresses[1][address_2]', null, array('class' => 'form-control', 'ng-model' => 'billing.address_2')) }}
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('addresses[1][city]', 'City') }}
				        {{ Form::text('addresses[1][city]', null, array('class' => 'form-control', 'ng-model' => 'billing.city')) }}
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('addresses[1][state]', 'State') }}
				        <br>
				        {{ Form::select('addresses[1][state]', State::orderBy('full_name')->lists('full_name', 'abbr'), null, array('class' => 'form-control width-auto', 'ng-model' => 'billing.state')) }}
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('addresses[1][zip]', 'Zip') }}
				        {{ Form::text('addresses[1][zip]', null, array('class' => 'form-control', 'ng-model' => 'billing.zip')) }}
				    </div>
			    </div>
			    
			    <div class="form-group">
				    <label>
				    	<input type="checkbox" value="yes" name="shippingsameasbilling" ng-click="show=!show" checked>
				    	Shipping address same as billing address
				    </label>
				</div>
				
			    <div ng-show="show" id="address-shipping">
			    	<h3>Shipping Address</h3>
			    	{{ Form::hidden('addresses[2][label]', 'Shipping') }}
				    <div class="form-group">
				        {{ Form::label('addresses[2][address_1]', 'Address 1') }}
				        {{ Form::text('addresses[2][address_1]', null, array('class' => 'form-control')) }}
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('addresses[2][address_2]', 'Address 2') }}
				        {{ Form::text('addresses[2][address_2]', null, array('class' => 'form-control')) }}
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('addresses[2][city]', 'City') }}
				        {{ Form::text('addresses[2][city]', null, array('class' => 'form-control')) }}
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('addresses[2][state]', 'State') }}
				        <br>
				        {{ Form::select('addresses[2][state]', State::orderBy('full_name')->lists('full_name', 'abbr'), null, array('class' => 'form-control width-auto')) }}
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('addresses[2][zip]', 'Zip') }}
				        {{ Form::text('addresses[2][zip]', null, array('class' => 'form-control')) }}
				    </div>
			    </div>
				
				<div class="form-group">
					<button type="button" class="btn btn-primary" ng-click="saveShippingAddress($data)">Next <i class="fa fa-angle-right"></i></button>
				</div>

	        </div><!-- col -->
	    </div><!-- row -->
	{{Form::close()}}
</div>
