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
	<div class="row" ng-controller="UserController">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}
		
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
				    	'2' => 'ISM',
				    	'3' => 'Editor',
				    	'4' => 'Admin'
				    ), null, array('class' => 'selectpicker')) }}
			    </div>
		    
			    <div class="form-group dropdown">
			        {{ Form::label('sponsor_id', 'Sponsor Id') }}
			        {{ Form::text('sponsor_id', null, array('ng-model'=>'sponsor','option'=>'names','item'=>'sponsor','class' => 'form-control autoComplete dropdown-toggle','url'=>'/api/all-users/1/','id'=>'dropdownMenu1','data-toggle'=>'dropdown','aria-expanded'=>'true')) }}
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" >
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"  ng-repeat="name in names">@{{name}}</a></li>
                      </ul>
			    </div>
                <div>@{{sponsor}}</div>
			    
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
<script>

    var app = angular.module('app', []).directive('autoComplete', ['$http','$q',function($http, $q) {
        return {
            restrict:'AEC',
            scope:{
                data: '=item',
                list: '=option'
            },
            link:function(scope,elem,attrs){
                scope.suggestions=[];

                scope.selectedTags=[];
                
                scope.selectedIndex=-1;

                scope.removeTag=function(index){
                    scope.selectedTags.splice(index,1);
                }

                scope.addToSelectedTags=function(index){
                    if(scope.selectedTags.indexOf(scope.suggestions[index])===-1){
                        scope.selectedTags.push(scope.suggestions[index]);
                        scope.searchText='';
                        scope.suggestions=[];
                    }
                }

                scope.checkKeyDown=function(event){
                    if(event.keyCode===40){
                        event.preventDefault();
                        if(scope.selectedIndex+1 !== scope.suggestions.length){
                            scope.selectedIndex++;
                        }
                    }
                    else if(event.keyCode===38){
                        event.preventDefault();
                        if(scope.selectedIndex-1 !== -1){
                            scope.selectedIndex--;
                        }
                    }
                    else if(event.keyCode===13){
                        scope.addToSelectedTags(scope.selectedIndex);
                    }
                }

                scope.$watch('selectedIndex',function(val){
                    console.log('called selectedIndex' );
                    console.log(val);
                    if(val!==-1) {
                        scope.searchText = scope.suggestions[scope.selectedIndex];
                    }
                });
                
                scope.$watch('data', function(val){
                    if(val != undefined && val.length >= 3){
                        $http.get(attrs.url+'?q='+scope.data).success(function(v){
                            scope.list = v.data.map(function(a){
                                return a.full_name;
                            });
                        });        
                    }
                });
                
            }
        }
    }]);
    
    function UserController($scope){
        //$scope.names = ["john", "bill", "charlie", "robert", "alban", "oscar", "marie", "celine", "brad", "drew", "rebecca", "michel", "francis", "jean", "paul", "pierre", "nicolas", "alfred", "gerard", "louis", "albert", "edouard", "benoit", "guillaume", "joseph"];
        console.log("called user cont");
    }
</script>
@stop    
