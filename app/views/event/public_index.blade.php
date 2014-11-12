@extends('layouts.gray')
@section('content')
<div ng-app="app" class="index">
    <div ng-controller="uventController" class="my-controller">
    	<div class="page-actions">
	        <div class="row">
	            <div class="col col-md-8">
	                <h1 class="no-top">Upcoming Events</h1>
	            </div>
	            <div class="col col-md-4">
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
	                <!-- <div class="pull-right">
	                    <div class="input-group">
	                        <span class="input-group-addon">Count</span>
	                        <input type="number" min="1" class="form-control itemsPerPage" ng-model="pageSize">
	                    </div>
	                </div>
	                <h4 class="pull-right no-top currentPage margin-right-1">Page <span ng-bind="currentPage"></span></h4> -->
	            </div>
	        </div><!-- row -->
	    </div><!-- page-actions -->
        <div class="row">
            <div class="col col-md-12">
                <table class="table">
                    <thead>
                        <tr>
	                        
                        	<th class="link hidable-xs" ng-click="orderByField='date_start'; reverseSort = !reverseSort">Date
                        		<span>
                        			<span ng-show="orderByField == 'date_start'">
                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                        			</span>
                        		</span>
                    		</th>
                        	
                        	<th class="link" ng-click="orderByField='name'; reverseSort = !reverseSort">Name
                        		<span>
                        			<span ng-show="orderByField == 'name'">
                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                        			</span>
                        		</span>
                    		</th>
                        	
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="event in events | filter:search | orderBy: 'date_start' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
							
				            <td class="date-col">
				                <span ng-bind="event.formatted_start_date"></span>
				            </td>
							
				            <td>
				                <a href="/public-events/@include('_helpers.uvent_id')"><span ng-bind="event.name"></span></a>
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
    </div><!-- app -->
@stop
@section('scripts')
<script>

	var app = angular.module('app', ['angularUtils.directives.dirPagination']);
	
	function uventController($scope, $http) {
		
		$http.get('/api/all-events-by-role').success(function(events) {
			$scope.events = events;
			console.log($scope.events);
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