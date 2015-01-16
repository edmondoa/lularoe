@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => '/users/email', 'method' => 'POST')) }}
	    <div ng-controller="DownlineController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		            	@if (Auth::user()->hasRepInDownline($user->id) || (Auth::user()->hasRole(['Superadmin', 'Admin']) && isset($user->sponsor_id)))
		            		<div class="breadcrumbs">
		            			<a href="/downline/all/{{ $user->sponsor_id }}"><i class="fa fa-arrow-up"></i> Up One Level</a>
		            		</div>
		            	@endif
		            	<h1 class="no-top pull-left no-pull-xs">
			            	@if ($user->id == Auth::user()->id)
			            		Your New Downline
			            	@else
			                	{{ $user->first_name }} {{ $user->last_name }}'s New Downline
			            	@endif
		            	</h1>
		            	<div class="pull-right hidable-xs">
		                    <div class="input-group pull-right">
		                    	<span class="input-group-addon no-width">Count</span>
		                    	<input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
		                    </div>
		                    <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
		            	</div>
			    	</div>
		        </div><!-- row -->
		        <div class="row">
		            <div class="col-md-6 col-sm-6 col-xs-12 page-actions-left">
		                <div class="pull-left">
		                    <div class="pull-left margin-right-2">
		                        <div class="input-group">
		                            <select class="form-control selectpicker actions">
		                                <option value="/users/public_email">Send Email</option>
		                                <option value="/users/sms">Send Text (SMS)</option>
		                            </select>
		                            <div class="input-group-btn no-width">
		                                <button class="btn btn-default applyAction" disabled>
		                                    <i class="fa fa-check"></i>
		                                </button>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="pull-left">
	                            <select class="form-control">
	                                <option ng-click="getStartDate(1)">Last 24 Hours</option>
	                                <option ng-click="getStartDate(7)" selected>Last 7 Days</option>
	                                <option ng-click="getStartDate(30)">Last 30 Days</option>
	                            </select>
		                    </div>
		                </div>
			        </div>
			        <div class="col-md-6 col-sm-6 col-xs-12">
		                <div class="input-group pull-right no-pull-xs">
		                    <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
		                    <span class="input-group-btn no-width">
		                        <button class="btn btn-default" type="button">
		                            <i class="fa fa-search"></i>
		                        </button>
		                    </span>
		                </div>
		            </div><!-- col -->
		        </div><!-- row -->
		    </div><!-- page-actions -->
	        <div class="row">
	            <div class="col col-md-12">
	                <table class="table">
	                    <thead>
	                        <tr>
	                            <th>
	                            	<input type="checkbox">
	                            </th>
	                            
	                            @if (Auth::user()->hasRole(['Rep']))
	                            	<th class="link" ng-click="orderByField='pivot.level'; reverseSort = !reverseSort">Level
	                            		<span>
	                            			<span ng-show="orderByField == 'pivot.level'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
	                        	@endif
                            	          
                            	<th class="link" ng-click="orderByField='created_at'; reverseSort = !reverseSort">Sign Up Time
                            		<span>
                            			<span ng-show="orderByField == 'created_at'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                            	                     			
                            	<th class="link" ng-click="orderByField='last_name'; reverseSort = !reverseSort">Name
                            		<span>
                            			<span ng-show="orderByField == 'last_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        	
                            	<th class="link" ng-click="orderByField='public_gender'; reverseSort = !reverseSort">Gender
                            		<span>
                            			<span ng-show="orderByField == 'public_gender'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='public_email'; reverseSort = !reverseSort">Email
                            		<span>
                            			<span ng-show="orderByField == 'public_email'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='public_phone'; reverseSort = !reverseSort">Phone
                            		<span>
                            			<span ng-show="orderByField == 'public_phone'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='min_commission'; reverseSort = !reverseSort">Rank
                            		<span>
                            			<span ng-show="orderByField == 'rank_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='front_line_count'; reverseSort = !reverseSort">Immediate Downline
                            		<span>
                            			<span ng-show="orderByField == 'rank_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='descendant_count'; reverseSort = !reverseSort">Total Downline
                            		<span>
                            			<span ng-show="orderByField == 'rank_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>

	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="user in users | filter:search | filter:greaterThan('created_at', startDate) | orderBy: -'created_at' | orderBy: 'pivot.level' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="user_ids[]" value="@include('_helpers.user_id')">
	                            </td>
	                            
					            <td>
					                <span ng-bind="user.created_at"></span>
					            </td>
	                            
	                            @if (Auth::user()->hasRole(['Rep']))
		                            <td>
						                <span ng-bind="user.pivot.level"></span></a>
		                            </td>
	                            @endif
	                            
	                            <td>
					                <a href="/users/@include('_helpers.user_id')" title="View Details"><span ng-bind="user.last_name"></span>, <span ng-bind="user.first_name"></span></a>
					            </td>
					            
					            <td>
					                <span ng-bind="user.public_gender"></span>
					            </td>
					            
					            <td>
					                <span ng-bind="user.public_email"></span>
					            </td>
					            		            
					            <td>
					                <span ng-bind="user.public_phone"></span>
					            </td>
					            
					            <td>
					            	<span ng-bind="user.rank_name"></span> (<span ng-bind="user.rank_id"></span>)
					            </td>
					            
					            <td>
					            	<a href="/downline/immediate/@include('_helpers.user_id')" title="View Direct Downline"><span ng-bind="user.front_line_count"></span></a>
					            </td>
					            
					            <td>
					            	<a href="/downline/all/@include('_helpers.user_id')" title="View All Downline"><span ng-bind="user.descendant_count"></span></a>
					            </td>
					            
	                        </tr>
	                        <tr dir-paginate-end></tr>
	                    </tbody>
	                </table>
	                @include('_helpers.loading')<div ng-controller="OtherController" class="other-controller">
	                    <div class="text-center">
	                        <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/packages/dirpagination/dirPagination.tpl.html"></dir-pagination-controls>
	                    </div>
	                </div>
	            </div><!-- col -->
	        </div><!-- row -->
        {{ Form::close() }}
    </div><!-- app -->
@stop
@section('scripts')
<script>

	var app = angular.module('app', ['angularUtils.directives.dirPagination']);
	
	function DownlineController($scope, $http) {
	
		$http.get('/api/new-downline/{{ $user->id }}').success(function(users) {
			$scope.users = users;
			console.log($scope.users);
			@include('_helpers.bulk_action_checkboxes')
			
		});
		
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		$scope.range = 7;
		$scope.getStartDate = function(range) {
			var d = new Date();
			d.setDate(d.getDate() - range);
		    var yyyy = d.getFullYear();
		    var mm = d.getMonth()+1; //January is 0!
		    var dd = d.getDate();
			var hh = d.getHours();
			var ii = d.getMinutes();
			var ss = d.getSeconds();
		    if(dd<10){
		        dd='0'+dd
		    } 
		    if(mm<10){
		        mm='0'+mm
		    } 
		    if(hh<10){
		        hh='0'+hh
		    } 
		    if(ii<10){
		        ii='0'+ii
		    }
		    if(ss<10){
		        ss='0'+ss
		    }
		    return $scope.startDate = yyyy + '-' + mm + '-' + dd + ' ' + hh + ':' + ii + ':' + ss;
		}
		$scope.getStartDate($scope.range);
		$scope.greaterThan = function(prop, val){
		    return function(item){
		      if (item[prop] > val) return true;
		    }
		}
		
		$scope.pageChangeHandler = function(num) {
			
		};
		
	}
	
	function OtherController($scope) {
		$scope.pageChangeHandler = function(num) {
		};
	}

</script>
@stop