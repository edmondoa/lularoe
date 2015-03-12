@extends('layouts.default')
@section('content')
<div class="edit" ng-app="app">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
			@if (Auth::user()->id == $user->id)
				<h1>Edit Profile</h1>
			@else
		    	<h1>Edit {{ $user->first_name }} {{ $user->last_name }}</h1>
		    @endif
		</div>
	</div>
	<div class="row" ng-controller="UserEditController">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}

			@if (Auth::user()->id == 0)
		    <div class="form-group">
		        {{ Form::label('consignment', 'Consignment Amount') }}
		        {{ Form::text('consignment', null, array('class' => 'form-control')) }}
		    </div>
			@endif
		
		    <div class="form-group">
		        {{ Form::label('first_name', 'First Name') }}
		        {{ Form::text('first_name', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('last_name', 'Last Name') }}
		        {{ Form::text('last_name', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('public_id', 'Public Id') }}
		        {{ Form::text('public_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('email', 'Email') }}
		        {{ Form::text('email', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('password', 'New Password') }}
		        {{ Form::password('password', array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('password_confirm', 'Confirm New Password') }}
		        {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
	    		{{ Form::label('gender', 'Gender') }}<br>
	    		{{ Form::select('gender', array(
			    	'M' => 'Male',
			    	'F' => 'Female',
			    ), null, array('class' => 'selectpicker')) }}
		    </div>
		    
		    <!-- <div class="form-group">
		        {{ Form::label('key', 'Key') }}
		        {{ Form::text('key', null, array('class' => 'form-control')) }}
		    </div> -->
		   
		    <div class="form-group">
		        {{ Form::label('dob', 'Date of Birth') }}
		        {{ Form::text('dob', null, array('class' => 'form-control dateonlypicker')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('phone', 'Phone') }}
		        {{ Form::text('phone', null, array('class' => 'form-control')) }}
		    </div>
		    
		    @if (Auth::user()->hasRole(['Superadmin', 'Admin']) && Auth::user()->id != $user->id)
		    	<div class="form-group">
		    		{{ Form::label('roled_id', 'Role') }}<br>
		    		{{ Form::select('role_id', array(
				    	'1' => 'Customer',
				    	'2' => Config::get('site.rep_title'),
				    	'3' => 'Editor',
				    	'4' => 'Admin'
				    ), null, array('class' => 'selectpicker')) }}
			    </div>
		    
			    <div class="form-group dropdown" ng-class="check_sponsor()">
			        {{ Form::label('sponsor_id', 'Sponsor Id') }}
                    {{ Form::text('sponsor_id', null, array('ng-init'=>'sponsor="'.$user->sponsor_id.'"','ng-model'=>'sponsor','option'=>'users','item'=>'sponsor','class' => 'form-control autoComplete dropdown-toggle','url'=>'/api/search-user/','id'=>'dropdownMenu1','data-toggle'=>'dropdown','aria-expanded'=>'true')) }}
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" >
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#" ng-click="update_sponsor(user)"  ng-repeat="user in users">@{{user.name}}</a></li>
                    </ul>
			    </div>
			    
                <div class="form-group" ng-show="showSponsorName">
                    {{ Form::label('sponsor_name', 'Sponsor Name') }}
                    <div>@{{sponsor_name}}</div>
                </div>
			    
			    <!-- <div class="form-group">
			        {{ Form::label('mobile_plan_id', 'Mobile Plan Id') }}
			        {{ Form::text('mobile_plan_id', null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('min_commission', 'Min Commission') }}
			        {{ Form::text('min_commission', null, array('class' => 'form-control')) }}
			    </div>
			   -->
			    <div class="form-group">
			        {{ Form::label('disabled', 'Status') }}
			        <br>
			    	{{ Form::select('disabled', [
			    		0 => 'Active',
			    		1 => 'Disabled'
			    	], $user->disabled, ['class' => 'selectpicker']) }}
			    </div>
			    
			@endif		    
		
		    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop
@section('scripts')
{{ HTML::script('js/controllers/userEditController.js') }}
@stop    
