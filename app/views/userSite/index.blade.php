@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'user-sites/disable', 'method' => 'POST')) }}
	    <div ng-controller="UserSiteController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">All UserSites</h1>
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
		        	@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
			    		<div class="col-md-6 col-sm-6 col-xs-12 page-actions-left">
			                <div class="pull-left">
			                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('userSites/create') }}"><i class="fa fa-plus"></i></a>
			                    <div class="pull-left">
			                        <div class="input-group">
			                            <select class="form-control selectpicker actions">
			                                <option value="events/disable" selected>Disable</option>
			                                <option value="events/enable">Enable</option>
			                                <option value="events/delete">Delete</option>
			                            </select>
			                            <div class="input-group-btn no-width">
			                                <button class="btn btn-default applyAction" disabled>
			                                    <i class="fa fa-check"></i>
			                                </button>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			        	</div>
			        	<div class="col-md-6 col-sm-6 col-xs-12">
					@else
						<div class="col-md-12 col-sm-12 col-xs-12">
					@endif
		                <div class="pull-right">
		                    <div class="input-group">
		                        <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
		                        <span class="input-group-btn no-width">
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
                            	
                            	<th class="link" ng-click="orderByField='user_id'; reverseSort = !reverseSort">User Id
                            		<span>
                            			<span ng-show="orderByField == 'user_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='body'; reverseSort = !reverseSort">Body
                            		<span>
                            			<span ng-show="orderByField == 'body'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
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
	                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="userSite in userSites | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.userSite_id')">
	                            </td>
								
					            <td>
					                <a href="/user-sites/@include('_helpers.userSite_id')"><span ng-bind="userSite.user_id"></span></a>
					            </td>
					            
					            <td>
					                <a href="/user-sites/@include('_helpers.userSite_id')"><span ng-bind="userSite.body"></span></a>
					            </td>
					            
					            <td>
					            	<a href="/user-sites/@include('_helpers.userSite_id')"><span ng-bind="userSite.updated_at"></span></a>
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
	
	function UserSiteController($scope, $http) {
	
		$http.get('/api/all-userSites').success(function(userSites) {
			$scope.userSites = userSites;
			
			@include('_helpers.bulk_action_checkboxes')
			
		});
		
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		$scope.meals = [];
		
		$scope.pageChangeHandler = function(num) {
			
		};
		
	}
	
	function OtherController($scope) {
		$scope.pageChangeHandler = function(num) {
		};
	}

</script>
@stop