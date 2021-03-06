@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'emailMessages/disable', 'method' => 'POST')) }}
	    <div ng-controller="EmailMessageController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">All EmailMessages</h1>
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
		                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('emailMessages/create') }}"><i class="fa fa-plus"></i></a>
		                    <div class="pull-left">
		                        <div class="input-group">
		                            <select class="form-control selectpicker actions">
		                                <option value="emailMessages/disable" selected>Disable</option>
		                                <option value="emailMessages/enable">Enable</option>
		                                <option value="emailMessages/delete">Delete</option>
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
                            	
                            	<th class="link" ng-click="orderByField='sender_id'; reverseSort = !reverseSort">Sender Id
                            		<span>
                            			<span ng-show="orderByField == 'sender_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='recipient_id'; reverseSort = !reverseSort">Recipient Id
                            		<span>
                            			<span ng-show="orderByField == 'recipient_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='subject'; reverseSort = !reverseSort">Subject
                            		<span>
                            			<span ng-show="orderByField == 'subject'">
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
                        		
                            	<th class="link" ng-click="orderByField='disabled'; reverseSort = !reverseSort">Disabled
                            		<span>
                            			<span ng-show="orderByField == 'disabled'">
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
	                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="emailMessage in emailMessages | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.emailMessage_id')">
	                            </td>
								
					            <td>
					                <a href="/emailMessages/@include('_helpers.emailMessage_id')"><span ng-bind="emailMessage.sender_id"></span></a>
					            </td>
					            
					            <td>
					                <a href="/emailMessages/@include('_helpers.emailMessage_id')"><span ng-bind="emailMessage.recipient_id"></span></a>
					            </td>
					            
					            <td>
					                <a href="/emailMessages/@include('_helpers.emailMessage_id')"><span ng-bind="emailMessage.subject"></span></a>
					            </td>
					            
					            <td>
					                <a href="/emailMessages/@include('_helpers.emailMessage_id')"><span ng-bind="emailMessage.body"></span></a>
					            </td>
					            
					            <td>
					                <a href="/emailMessages/@include('_helpers.emailMessage_id')"><span ng-bind="emailMessage.disabled"></span></a>
					            </td>
					            
					            <td>
					            	<a href="/emailMessages/@include('_helpers.emailMessage_id')"><span ng-bind="emailMessage.updated_at"></span></a>
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
	
	function EmailMessageController($scope, $http) {
	
		$http.get('/api/all-emailMessages').success(function(emailMessages) {
			$scope.emailMessages = emailMessages;
			
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