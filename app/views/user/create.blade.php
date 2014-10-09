@section('content')
<div class="row">
	<div class="col col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
		<h2>Sign Up</h2>
	    {{ Form::open(array('url' => 'user', 'class' => 'full')) }}
	
	    <div class="form-group">
	        {{ Form::label('sponsor_id', 'Sponsor ID (required)') }}
	        {{ Form::text('sponsor_id', Input::old('sponsor_id'), array('class' => 'form-control')) }}
	    </div>
	    
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
	        {{ Form::label('password', 'Password') }}
	        {{ Form::password('password', array('class' => 'form-control')) }}
	    </div>
	    
		<div class="form-group">
			{{ Form::label('password_confirmation','* Enter it again') }}
			{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
		</div>
	    
		<div class="form-group">
			{{ Form::radio('gender', 'M', true, array('id' => 'gender_male')) }}
			{{ Form::label('gender_male', 'Male') }}
			<br>
			{{ Form::radio('gender', 'F', false, array('id' => 'gender_female')) }}
			{{ Form::label('gender_female', 'Female') }}
		</div>
	    
	    <div class="form-group">
		    <?php $name = 'dob' ?>
			@include('_helpers.dob')
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
	        {{ Form::text('state', Input::old('state'), array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('addressable_id', 'Addressable Id') }}
	        {{ Form::text('addressable_id', Input::old('addressable_id'), array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('zip', 'Zip') }}
	        {{ Form::text('zip', Input::old('zip'), array('class' => 'form-control')) }}
	    </div>
	    
	    {{ Form::submit('Sign Up', array('class' => 'btn btn-success')) }}
	
	    {{ Form::close() }}
	</div>
</div>
@stop