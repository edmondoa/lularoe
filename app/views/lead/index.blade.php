@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'users/email', 'method' => 'POST')) }}
    	{{ Form::hidden('leads', 1) }}
	    <div ng-controller="LeadController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col col-md-8">
		                <h1 class="no-top">All Leads</h1>
		            </div>
		            <div class="col col-md-4">
		                <div class="pull-right">
		                    <div class="input-group">
		                        <span class="input-group-addon">Count</span>
		                        <input type="number" min="1" class="form-control itemsPerPage" ng-model="pageSize">
		                    </div>
		                </div>
		                <h4 class="pull-right no-top currentPage margin-right-1">Page <span ng-bind="currentPage"></span></h4>
		            </div>
		        </div><!-- row -->
		        <div class="row">
		            <div class="col col-md-12">
		                <div class="pull-left">
		                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('leads/create') }}"><i class="fa fa-plus"></i></a>
		                    <div class="pull-left">
		                        <div class="input-group">
		                            <select class="form-control selectpicker actions">
		                                <option value="/users/email" selected>Send Email</option>
		                                <option value="/users/sms">Send Text (SMS)</option>
		                                <!-- <option value="leads/disable" selected>Disable</option>
		                                <option value="leads/enable">Enable</option> -->
		                                <option value="leads/delete">Delete</option>
		                            </select>
		                            <div class="input-group-btn">
		                                <button class="btn btn-default applyAction" disabled>
		                                    <i class="fa fa-check"></i>
		                                </button>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="pull-right">
		                    <div class="input-group">
		                        <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
		                        <span class="input-group-btn">
		                            <button class="btn btn-default" type="button">
		                                <i class="fa fa-search"></i>
		                            </button>
		                        </span>
		                    </div>
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
                        		
                            	<th class="link" ng-click="orderByField='last_name'; reverseSort = !reverseSort">Name
                            		<span>
                            			<span ng-show="orderByField == 'last_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='email'; reverseSort = !reverseSort">Email
                            		<span>
                            			<span ng-show="orderByField == 'email'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='gender'; reverseSort = !reverseSort">Gender
                            		<span>
                            			<span ng-show="orderByField == 'gender'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='dob'; reverseSort = !reverseSort">Dob
                            		<span>
                            			<span ng-show="orderByField == 'dob'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='phone'; reverseSort = !reverseSort">Phone
                            		<span>
                            			<span ng-show="orderByField == 'phone'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                        		@if (Auth::user()->hasRole(['Superadmin','Admin']))
	                            	<th class="link" ng-click="orderByField='sponsor_name'; reverseSort = !reverseSort">Sponsor
	                            		<span>
	                            			<span ng-show="orderByField == 'sponsor_name'">
		                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
		                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
	                            			</span>
	                            		</span>
	                        		</th>
                        		@endif
                        		
                            	<th class="link" ng-click="orderByField='opportunity_name'; reverseSort = !reverseSort">Opportunity
                            		<span>
                            			<span ng-show="orderByField == 'opportunity_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<!-- <th class="link" ng-click="orderByField='disabled'; reverseSort = !reverseSort">Disabled
                            		<span>
                            			<span ng-show="orderByField == 'disabled'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th> -->
                        		
                            	<th class="link" ng-click="orderByField='updated_at'; reverseSort = !reverseSort">Modified
                            		<span>
                            			<span ng-show="orderByField == 'updated_at'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="lead in leads | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="user_ids[]" value="@include('_helpers.lead_id')">
	                            </td>
								
					            <td>
					                <a href="/leads/@include('_helpers.lead_id')"><span ng-bind="lead.first_name"></span>, <span ng-bind="lead.last_name"></span></a>
					            </td>
					            
					            <td>
					                <span ng-bind="lead.email"></span>
					            </td>
					            
					            <td>
					                <span ng-bind="lead.gender"></span>
					            </td>
					            
					            <td>
					                <span ng-bind="lead.dob"></span>
					            </td>
					            
					            <td>
					                <span ng-bind="lead.phone"></span>
					            </td>
					            
					            @if (Auth::user()->hasRole(['Superadmin','Admin']))
						            <td>
						                <span ng-bind="lead.sponsor_name"></span>
						            </td>
					            @endif
					            <td>
					                <span ng-bind="lead.opportunity_name"></span>
					            </td>
					            
					            <!-- <td>
					                <span ng-bind="lead.disabled"></span>
					            </td> -->
					            
					            <td>
					            	<span ng-bind="lead.updated_at"></span>
					            </td>
	                        </tr>
	                        <tr dir-paginate-end></tr>
	                    </tbody>
	                </table>
	                @include('_helpers.loading')
	                <div ng-controller="OtherController" class="other-controller">
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
	
	function LeadController($scope, $http) {
	
		$http.get('/api/all-leads-by-rep/{{ Auth::user()->id }}').success(function(leads) {
			$scope.leads = leads;
			
			@include('_helpers.bulk_action_checkboxes')
			
		});
		
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		$scope.meals = [];
		
		$scope.pageChangeHandler = function(num) {
			console.log('meals page changed to ' + num);
		};
		
	}
	
	function OtherController($scope) {
		$scope.pageChangeHandler = function(num) {
		};
	}

</script>
@stop